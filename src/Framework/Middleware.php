<?php
declare(strict_types=1);

namespace Solos\Framework;

interface Middleware
{
    public function run(Context $context, callable $next): void;
}
