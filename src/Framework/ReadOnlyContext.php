<?php
declare(strict_types=1);

namespace Solos\Framework;

/**
 * @final
 */
class ReadOnlyContext
{
    /**
     * @internal
     */
    public function __construct(private readonly Context $context)
    {
    }

    public function get(string $key): mixed
    {
        return $this->context->get($key);
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return $this->context->toArray();
    }
}
