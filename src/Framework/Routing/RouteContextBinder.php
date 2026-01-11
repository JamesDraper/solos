<?php
declare(strict_types=1);

namespace Solos\Framework\Routing;

use Solos\Framework\MutableContext;

interface RouteContextBinder
{
    public function __invoke(Route $route, MutableContext $context): void;
}
