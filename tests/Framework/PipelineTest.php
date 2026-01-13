<?php
declare(strict_types=1);

namespace Tests\Framework;

use Solos\Framework\Middleware;
use Solos\Framework\Pipeline;
use Solos\Framework\Handler;
use Solos\Framework\Context;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

use Mockery;

final class PipelineTest extends TestCase
{
    #[Test]
    public function it_executes_middlewares_and_handler_in_order(): void
    {
        $context = new Context();

        $order = [];

        $middlewareA = Mockery::mock(Middleware::class);
        $middlewareA
            ->shouldReceive('run')
            ->once()
            ->withArgs(function(Context $context, callable $next) use (&$order) {
                $order[] = 'mwa-before';

                $next($context);

                $order[] = 'mwa-after';
                
                return true;
            });

        $middlewareB = Mockery::mock(Middleware::class);
        $middlewareB
            ->shouldReceive('run')
            ->once()
            ->withArgs(function(Context $context, callable $next) use (&$order) {
                $order[] = 'mwb-before';
                
                $next($context);
                
                $order[] = 'mwb-after';
                
                return true;
            });

        $handler = Mockery::mock(Handler::class);
        $handler
            ->shouldReceive('run')
            ->once()
            ->withArgs(function(Context $context) use (&$order) {
                $order[] = 'handler';

                return true;
            });

        $pipeline = new Pipeline($handler, $middlewareA, $middlewareB);

        $pipeline->run($context);

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
        $context = new Context();

        $called = [];

        $middleware = Mockery::mock(Middleware::class);
        $middleware
            ->shouldReceive('run')
            ->once()
            ->withArgs(function(Context $context, $next) use (&$called) {
                $called[] = 'middleware';

                return true;
            });

        $handler = Mockery::mock(Handler::class);
        $handler->shouldNotReceive('run');

        $pipeline = new Pipeline($handler, $middleware);

        $pipeline->run($context);

        $this->assertSame(['middleware'], $called);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        Mockery::close();
    }
}
