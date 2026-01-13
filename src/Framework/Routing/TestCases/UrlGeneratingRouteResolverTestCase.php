<?php
declare(strict_types=1);

namespace Solos\Framework\Routing\TestCases;

use Solos\Framework\Routing\UrlGeneratingRouteResolver;
use Solos\Framework\ReadOnlyContext;
use Solos\Framework\Routing\Route;
use Solos\Framework\Context;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

use function array_map;

abstract class UrlGeneratingRouteResolverTestCase extends TestCase
{
    abstract protected function makeUrlGeneratingRouteResolver(): UrlGeneratingRouteResolver;

    /**
     * @return array<string, array{url: string, route: Route, context: Context}>
     */
    abstract protected static function getRouteData();

    final public static function resolveRouteProvider(): array
    {
        $routeData = static::getRouteData();

        return array_map(function (array $data): array {
            return [
                'route' => $data['route'],
                'context' => $data['context'],
            ];
        }, $routeData);
    }

    final public static function generateUrlProvider(): array
    {
        $routeData = static::getRouteData();

        return array_map(function (array $data): array {
            return [
                'url' => $data['url'],
                'route' => $data['route'],
            ];
        }, $routeData);
    }

    #[Test]
    #[DataProvider('resolveRouteProvider')]
    final public function route_can_be_resolved(Route $route, Context $context): void
    {
        $urlGeneratingRouteResolver = $this->makeUrlGeneratingRouteResolver();

        $readOnlyContext = new ReadOnlyContext($context);

        $resolvedRoute = $urlGeneratingRouteResolver->resolveRoute($readOnlyContext);

        $this->assertEquals($route, $resolvedRoute);
    }

    #[Test]
    #[DataProvider('generateUrlProvider')]
    final public function url_can_be_generated(string $url, Route $route): void
    {
        $urlGeneratingRouteResolver = $this->makeUrlGeneratingRouteResolver();

        $generatedUrl = $urlGeneratingRouteResolver->generateUrl($route);

        $this->assertSame($url, $generatedUrl);
    }
}
