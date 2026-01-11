<?php
declare(strict_types=1);

namespace Solos;

use Psr\Http\Message\ResponseInterface as Response;

interface ContextResponseFactory
{
    public function __invoke(MutableContext $context): Response;
}
