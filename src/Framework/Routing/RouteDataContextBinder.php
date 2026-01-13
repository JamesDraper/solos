<?php
declare(strict_types=1);

namespace Solos\Framework\Routing;

use Solos\Framework\Context;

interface RouteDataContextBinder
{
    public function bindRouteDataToContext(Route $route, Context $context): void;
}
