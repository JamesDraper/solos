<?php
declare(strict_types=1);

namespace Tests\Unit\Layer2\Framework;

use Solos\Framework\Middleware;
use Solos\Framework\Pipeline;
use Solos\Framework\Handler;
use Solos\Framework\Context;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

use ArrayObject;

final class PipelineTest extends TestCase
{
    #[Test]
    public function it_executes_middlewares_and_handler_in_order(): void
    {
        /**
         * @var ArrayObject<int, string> $order
         */
        $order = new ArrayObject;

        $context = new Context;

        $context->set('order', $order);

        $middlewareA = new class implements Middleware {
            public function run(Context $context, callable $next): void
            {
                /**
                 * @var ArrayObject<int, string> $order
                 */
                $order = $context->get('order');

                $order->append('mwa-before');

                $next($context);

                $order->append('mwa-after');
            }
        };

        $middlewareB = new class implements Middleware {
            public function run(Context $context, callable $next): void
            {
                /**
                 * @var ArrayObject<int, string> $order
                 */
                $order = $context->get('order');

                $order->append('mwb-before');

                $next($context);

                $order->append('mwb-after');
            }
        };

        $handler = new class implements Handler {
            public function run(Context $context): void
            {
                /**
                 * @var ArrayObject<int, string> $order
                 */
                $order = $context->get('order');

                $order->append('handler');
            }
        };

        $pipeline = new Pipeline($handler, $middlewareA, $middlewareB);

        $pipeline->run($context);

        $this->assertSame([
            'mwa-before',
            'mwb-before',
            'handler',
            'mwb-after',
            'mwa-after',
        ], $order->getArrayCopy());
    }

    #[Test]
    public function middleware_can_short_circuit(): void
    {
        /**
         * @var ArrayObject<int, string> $order
         */
        $order = new ArrayObject;

        $context = new Context;

        $context->set('order', $order);

        $middleware = new class implements Middleware {
            public function run(Context $context, callable $next): void
            {
                /**
                 * @var ArrayObject<int, string> $order
                 */
                $order = $context->get('order');

                $order->append('middleware');
            }
        };

        $handler = new class implements Handler {
            public function run(Context $context): void
            {
                /**
                 * @var ArrayObject<int, string> $order
                 */
                $order = $context->get('order');

                $order->append('handler');
            }
        };

        $pipeline = new Pipeline($handler, $middleware);

        $pipeline->run($context);

        $this->assertSame(['middleware'], $order->getArrayCopy());
    }
}
