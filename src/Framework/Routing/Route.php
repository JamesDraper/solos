<?php
declare(strict_types=1);

namespace Solos\Framework\Routing;

use LogicException;

final class Route
{
    private const PARAMETER_TYPES = [
        'boolean',
        'integer',
        'string',
        'double',
        'NULL',
    ];

    private readonly string $name;

    private array $parameters = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setParameter(string $key, mixed $value): self
    {
        if (! $this->isScalar($value)) {
            throw $this->makeParameterTypeException($value);
        }

        $this->parameters[$key] = $value;

        return $this;
    }

    public function getParameter(string $key): mixed
    {
        return $this->parameters[$key] ?? null;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }

    private function isScalar(mixed $value): bool
    {
        return in_array(gettype($value), self::PARAMETER_TYPES);
    }

    private function makeParameterTypeException(mixed $value): LogicException
    {
        return new LogicException(sprintf(
            'Route parameters must be scalar values, got %s.',
            gettype($value),
        ));
    }
}
