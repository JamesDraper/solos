<?php
declare(strict_types=1);

namespace Solos\Framework;

use Psr\Http\Message\ServerRequestInterface as Request;

final class DefaultRequestContextFactory implements RequestContextFactory
{
    public function makeContextFromRequest(Request $request): Context
    {
        $context = new Context;

        $context->set(Key::REQUEST_METHOD, ucfirst((string) $request->getMethod()));
        
        $context->set(Key::REQUEST_URI, (string) $request->getUri());

        $context->set(Key::REQUEST_BODY, (string) $request->getBody());

        return $context;
    }
}
