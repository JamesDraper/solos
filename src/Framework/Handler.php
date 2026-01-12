<?php
declare(strict_types=1);

namespace Solos\Framework;

interface Handler
{
    public function __invoke(Context $context): void;
}
