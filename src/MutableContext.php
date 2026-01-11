<?php
declare(strict_types=1);

namespace Solos;

final class MutableContext
{
    /**
     * @var array<string, mixed>
     */
    private array $data = [];

    public function set(string $key, mixed $value): self
    {
        $this->data[$key] = $value;
        
        return $this;
    }

    public function get(string $key): mixed
    {
        return $this->data[$key] ?? null;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return $this->data;
    }
}
