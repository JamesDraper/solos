<?php
declare(strict_types=1);

namespace Solos\Framework\Routing;

use Solos\Framework\ReadOnlyContext;
use Solos\Framework\Pipeline;
use Solos\Framework\Context;
use Solos\Framework\Handler;

/**
 * @final
 */
class RoutingHandler implements Handler
{
    private array $pipelines = [];

    public function __construct(
        private readonly RouteResolver $routeResolver,
        private readonly RouteDataContextBinder $routeDataContextBinder,
        private readonly PipelineFactory $pipelineFactory,
    ) {
    }

    public function run(Context $context): void
    {
        $readOnlyContext = $this->makeReadOnlyContext($context);

        $route = $this->routeResolver->resolveRoute($readOnlyContext);

        $this->routeDataContextBinder->bindRouteDataToContext($route, $context);

        $pipeline = $this->getPipelineForRoute($route->getName());

        $pipeline->run($context);
    }

    protected function makeReadOnlyContext(Context $context): ReadOnlyContext
    {
        return new ReadOnlyContext($context);
    }

    private function getPipelineForRoute(string $routeName): Pipeline
    {
        if (!isset($this->pipelines[$routeName])) {
            $this->pipelines[$routeName] = $this->pipelineFactory->makePipelineForRoute($routeName);
        }

        return $this->pipelines[$routeName];
    }
}
