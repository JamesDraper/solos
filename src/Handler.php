<?php
declare(strict_types=1);

namespace Solos;

interface Handler
{
    public function __invoke(MutableContext $context): void;
}
