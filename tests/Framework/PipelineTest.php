<?php
declare(strict_types=1);

namespace Tests\Framework;

use Solos\Framework\MutableContext;
use Solos\Framework\Middleware;
use Solos\Framework\Pipeline;
use Solos\Framework\Handler;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

use Mockery;

final class PipelineTest extends TestCase
{
    #[Test]
    public function it_executes_middlewares_and_handler_in_order(): void
    {
        $context = new MutableContext();

        $order = [];

        $middlewareA = Mockery::mock(Middleware::class);
        $middlewareA
            ->shouldReceive('__invoke')
            ->once()
            ->withArgs(function(MutableContext $context, callable $next) use (&$order) {
                $order[] = 'mwa-before';

                $next($context);

                $order[] = 'mwa-after';
                
                return true;
            });

        $middlewareB = Mockery::mock(Middleware::class);
        $middlewareB
            ->shouldReceive('__invoke')
            ->once()
            ->withArgs(function(MutableContext $context, callable $next) use (&$order) {
                $order[] = 'mwb-before';
                
                $next($context);
                
                $order[] = 'mwb-after';
                
                return true;
            });

        $handler = Mockery::mock(Handler::class);
        $handler
            ->shouldReceive('__invoke')
            ->once()
            ->withArgs(function(MutableContext $context) use (&$order) {
                $order[] = 'handler';

                return true;
            });

        $pipeline = new Pipeline($handler, $middlewareA, $middlewareB);

        $pipeline($context);

        $this->assertSame(
            [
                'mwa-before',
                'mwb-before',
                'handler',
                'mwb-after',
                'mwa-after',
            ],
            $order,
        );
    }

    #[Test]
    public function middleware_can_short_circuit(): void
    {
        $context = new MutableContext();

        $called = [];

        $middleware = Mockery::mock(Middleware::class);
        $middleware
            ->shouldReceive('__invoke')
            ->once()
            ->withArgs(function(MutableContext $context, $next) use (&$called) {
                $called[] = 'middleware';

                return true;
            });

        $handler = Mockery::mock(Handler::class);
        $handler->shouldNotReceive('__invoke');

        $pipeline = new Pipeline($handler, $middleware);

        $pipeline($context);

        $this->assertSame(['middleware'], $called);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        Mockery::close();
    }
}
