<?php
declare(strict_types=1);

namespace Solos\Framework;

final class Pipeline
{
    /**
     * @var callable
     */
    private $pipeline;

    public function __construct(Handler $handler, Middleware ...$middlewares)
    {
        $this->pipeline = array_reduce(
            array_reverse($middlewares),
            function (callable $next, Middleware $middleware): callable {
                return $this->wrapMiddleware($middleware, $next);
            },
            $this->wrapHandler($handler),
        );
    }

    public function __invoke(MutableContext $context): void
    {
        ($this->pipeline)($context);
    }

    private function wrapMiddleware(Middleware $middleware, callable $next): callable
    {
        return function (MutableContext $context) use ($middleware, $next): void {
            $middleware($context, $next);
        };
    }

    private function wrapHandler(Handler $handler): callable
    {
        return function (MutableContext $context) use ($handler): void {
            $handler($context);
        };
    }
}
