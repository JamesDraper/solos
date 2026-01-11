<?php
declare(strict_types=1);

namespace Solos\Framework\Routing;

use Solos\Framework\MutableContext;

final class DefaultRouteContextBinder implements RouteContextBinder
{
    public function __invoke(Route $route, MutableContext $context): void
    {
        $context->set(Key::ROUTE_NAME, $route->getName());
        $context->set(Key::ROUTE_PARAMETERS, $route->getParameters());
    }
}
