<?php
declare(strict_types=1);

namespace Solos\Framework;

final class Key
{
    public const REQUEST_METHOD = 'request.method';

    public const REQUEST_URI = 'request.uri';

    public const REQUEST_BODY = 'request.body';

    public const ROUTE_NAME = 'route.name';

    public const ROUTE_PARAMETERS = 'route.parameters';

    private function __construct()
    {
    }
}
