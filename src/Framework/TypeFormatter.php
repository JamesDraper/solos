<?php
declare(strict_types=1);

namespace Solos\Framework;

use function get_class;
use function sprintf;

/**
 * @internal
 *
 * TODO: Maybe find a better home for this class than Framework root.
 */
final class TypeFormatter
{
    public static function format(mixed $value): string
    {
        $type = gettype($value);

        return match ($type) {
            'boolean' => 'bool',
            'integer' => 'int',
            'double' => 'float',
            'string' => 'string',
            'array' => 'array',
            'object' => self::formatObject($value),
            'resource', 'resource (closed)' => 'resource',
            'NULL' => 'null',
            default => $type,
        };
    }

    private static function formatObject(mixed $value): string
    {
        /**
         * @var object $object
         */
        $object = $value;

        return sprintf('object(%s)', get_class($object));
    }

    private function __construct()
    {
    }
}
