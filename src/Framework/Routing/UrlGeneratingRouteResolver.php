<?php
declare(strict_types=1);

namespace Solos\Framework\Routing;

interface UrlGeneratingRouteResolver extends RouteResolver
{
    public function generateUrl(Route $route): string;
}
