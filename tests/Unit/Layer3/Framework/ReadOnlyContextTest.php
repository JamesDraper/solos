<?php
declare(strict_types=1);

namespace Tests\Unit\Layer3\Framework;

use Solos\Framework\ReadOnlyContext;
use Solos\Framework\Context;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class ReadOnlyContextTest extends TestCase
{
    private ReadOnlyContext $readOnlyContext;

    private Context $context;

    #[Test]
    public function it_calls_get_on_context(): void
    {
        $this->context->set('one', 'two');

        $this->assertSame('two', $this->readOnlyContext->get('one'));
    }

    #[Test]
    public function it_call_to_array_on_context(): void
    {
        $this
            ->context
            ->set('one', 'two')
            ->set('three', 'four');

        $this->assertSame([
            'one' => 'two',
            'three' => 'four',
        ], $this->readOnlyContext->toArray());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->context = new Context;

        $this->readOnlyContext = new ReadOnlyContext($this->context);
    }
}
