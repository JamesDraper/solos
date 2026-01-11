<?php
declare(strict_types=1);

namespace Solos\Framework;

final class ImmutableContext
{
    private readonly MutableContext $context;

    /**
     * @internal
     */
    public static function make(MutableContext $context): self
    {
        return new self($context);
    }

    public function get(string $key): mixed
    {
        return $this->context->get($key);
    }

    /**
     * @internal
     */
    private function __construct(MutableContext $context)
    {
        $this->context = $context;
    }
}
