<?php
declare(strict_types=1);

namespace Solos\Framework\Routing\TestCases;

use Solos\Framework\Routing\RouteResolver;
use Solos\Framework\ReadOnlyContext;
use Solos\Framework\Routing\Route;
use Solos\Framework\Context;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

abstract class RouteResolverTestCase extends TestCase
{
    abstract protected function createRouteResolver(): RouteResolver;

    /**
     * @return array<string, array{route: Route, context: Context}>
     */
    abstract protected static function getRouteData();

    /**
     * @return array<string, array{route: Route, context: Context}>
     */
    final public static function resolveRouteProvider(): array
    {
        return static::getRouteData();
    }

    #[Test]
    #[DataProvider('resolveRouteProvider')]
    final public function route_can_be_resolved(Route $route, Context $context): void
    {
        $routeResolver = $this->createRouteResolver();

        $readOnlyContext = new ReadOnlyContext($context);

        $resolvedRoute = $routeResolver->resolveRoute($readOnlyContext);

        $this->assertEquals($route, $resolvedRoute);
    }
}
