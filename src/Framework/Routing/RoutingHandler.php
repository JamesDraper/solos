<?php
declare(strict_types=1);

namespace Solos\Framework\Routing;

use Solos\Framework\ImmutableContext;
use Solos\Framework\Pipeline;
use Solos\Framework\Handler;

final class RoutingHandler implements Handler
{
    private array $pipelines = [];

    public function __construct(
        private readonly RouteResolver $routeResolver,
        private readonly RouteContextBinder $routeContextBinder,
        private readonly PipelineFactory $pipelineFactory,
    ) {
    }

    public function __invoke(ImmutableContext $context): void
    {
        $route = $this->routeResolver->resolveRoute($context);

        ($this->routeContextBinder)($route, $context);

        $pipeline = $this->getPipelineForRoute($route->getName());

        $pipeline($context);
    }

    private function getPipelineForRoute(string $routeName): Pipeline
    {
        if (!isset($this->pipelines[$routeName])) {
            $this->pipelines[$routeName] = ($this->pipelineFactory)($routeName);
        }

        return $this->pipelines[$routeName];
    }
}
