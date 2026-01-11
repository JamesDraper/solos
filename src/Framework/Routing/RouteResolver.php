<?php
declare(strict_types=1);

namespace Solos\Framework\Routing;

use Solos\Framework\ImmutableContext;

interface RouteResolver
{
    public function __invoke(ImmutableContext $context): Route;
}
