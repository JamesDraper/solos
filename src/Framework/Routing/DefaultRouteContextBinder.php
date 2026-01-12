<?php
declare(strict_types=1);

namespace Solos\Framework\Routing;

use Solos\Framework\Context;

final class DefaultRouteContextBinder implements RouteContextBinder
{
    public function __invoke(Route $route, Context $context): void
    {
        $context->set(Key::ROUTE_NAME, $route->getName());
        $context->set(Key::ROUTE_PARAMETERS, $route->getParameters());
    }
}
