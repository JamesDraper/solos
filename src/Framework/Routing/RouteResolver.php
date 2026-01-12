<?php
declare(strict_types=1);

namespace Solos\Framework\Routing;

use Solos\Framework\ImmutableContext;

interface RouteResolver
{
    public function resolveRoute(ImmutableContext $context): Route;
}
