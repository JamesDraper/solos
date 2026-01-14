<?php
declare(strict_types=1);

namespace Tests\Unit\Layer1\Framework;

use Solos\Framework\Routing\Route;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

use InvalidArgumentException;
use stdClass;

final class RouteTest extends TestCase
{
    #[Test]
    public function it_gets_a_parameter(): void
    {
        $route = new Route('route.name', [
            'one' => 'two',
        ]);

        $this->assertSame('two', $route->getParameter('one'));
    }

    #[Test]
    public function it_gets_parameters(): void
    {
        $route = new Route('route.name', [
            'one' => 'two',
            'three' => 'four',
        ]);

        $this->assertSame([
            'one' => 'two',
            'three' => 'four',
        ], $route->getParameters());
    }

    #[Test]
    public function it_returns_true_when_a_parameter_exists(): void
    {
        $route = new Route('route.name', [
            'one' => 'two',
        ]);

        $this->assertTrue($route->hasParameter('one'));
    }

    #[Test]
    public function it_returns_false_when_a_parameter_does_not_exist(): void
    {
        $route = new Route('route.name', [
            'one' => 'two',
        ]);

        $this->assertFalse($route->hasParameter('three'));
    }

    #[Test]
    public function it_gets_null_for_missing_parameter(): void
    {
        $route = new Route('route.name', [
            'one' => 'two',
        ]);

        $this->assertNull($route->getParameter('three'));
    }

    #[Test]
    public function it_throws_if_a_parameter_is_not_scalar(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Route parameters must be scalar values'
        );

        // @phpstan-ignore-next-line argument.type
        new Route('route.name', [
            'object' => new stdClass,
        ]);
    }

    #[Test]
    public function it_throws_if_a_parameter_is_an_array(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Route parameters must be scalar values'
        );

        // @phpstan-ignore-next-line argument.type
        new Route('route.name', [
            'array' => [1, 2, 3],
        ]);
    }
}
