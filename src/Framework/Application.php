<?php
declare(strict_types=1);

namespace Solos\Framework;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class Application
{
    public function __construct(
        private readonly RequestContextFactory $requestContextFactory,
        private readonly Pipeline $pipeline,
        private readonly ContextResponseFactory $contextResponseFactory,
    ) {
    }

    public function __invoke(Request $request): Response
    {
        $context = ($this->requestContextFactory)($request);

        ($this->pipeline)($context);

        return ($this->contextResponseFactory)($context);
    }
}
