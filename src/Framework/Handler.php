<?php
declare(strict_types=1);

namespace Solos\Framework;

interface Handler
{
    public function run(Context $context): void;
}
