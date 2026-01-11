<?php
declare(strict_types=1);

namespace Solos\Framework\Routing;

use Solos\Framework\ImmutableContext;

interface RouteContextBinder
{
    public function __invoke(Route $route, ImmutableContext $context): void;
}
