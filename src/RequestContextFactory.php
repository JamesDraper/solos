<?php
declare(strict_types=1);

namespace Solos;

use Psr\Http\Message\ServerRequestInterface as Request;

interface RequestContextFactory
{
    public function __invoke(Request $request): MutableContext;
}
