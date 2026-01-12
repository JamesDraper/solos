<?php
declare(strict_types=1);

namespace Solos\Framework\Routing;

use Solos\Framework\Context;

interface RouteContextBinder
{
    public function __invoke(Route $route, Context $context): void;
}
