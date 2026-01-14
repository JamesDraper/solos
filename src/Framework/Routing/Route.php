<?php
declare(strict_types=1);

namespace Solos\Framework\Routing;

use Solos\Framework\TypeFormatter;

use InvalidArgumentException;

use function array_map;
use function in_array;
use function gettype;
use function sprintf;

final class Route
{
    private const SCALAR_TYPES = [
        'boolean',
        'integer',
        'string',
        'double',
        'NULL',
    ];

    private readonly string $name;

    /**
     * @var array<string, scalar>
     */
    private readonly array $parameters;

    /**
     * @param array<string, scalar> $parameters
     */
    public function __construct(string $name, array $parameters = [])
    {
        $this->name = $name;

        $this->parameters = array_map(function (mixed $value) {
            if (!$this->isScalar($value)) {
                throw $this->makeParameterTypeException($value);
            }

            return $value;
        }, $parameters);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function hasParameter(string $key): bool
    {
        return array_key_exists($key, $this->parameters);
    }

    public function getParameter(string $key): mixed
    {
        return $this->parameters[$key] ?? null;
    }

    /**
     * @return array<string, scalar>
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    private function isScalar(mixed $value): bool
    {
        return in_array(gettype($value), self::SCALAR_TYPES);
    }

    private function makeParameterTypeException(mixed $value): InvalidArgumentException
    {
        return new InvalidArgumentException(sprintf(
            'Route parameters must be scalar values, got "%s".',
            TypeFormatter::format($value),
        ));
    }
}
