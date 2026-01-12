<?php
declare(strict_types=1);

namespace Solos\Framework\Routing;

interface UrlGeneratingRouteResolver extends RouteResolver
{
    public function generateUrl(
        string $routeName,
        array $parameters = [],
    ): string;
}
