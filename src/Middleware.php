<?php
declare(strict_types=1);

namespace Solos;

interface Middleware
{
    public function __invoke(MutableContext $context, callable $next): void;
}
