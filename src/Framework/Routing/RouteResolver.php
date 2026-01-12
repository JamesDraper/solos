<?php
declare(strict_types=1);

namespace Solos\Framework\Routing;

use Solos\Framework\ReadOnlyContext;

interface RouteResolver
{
    public function resolveRoute(ReadOnlyContext $context): Route;
}
