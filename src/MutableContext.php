<?php
declare(strict_types=1);

namespace Solos;

final class MutableContext
{
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

    public function toArray(): array
    {
        return $this->data;
    }
}
