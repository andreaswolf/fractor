<?php

declare(strict_types=1);

namespace a9f\Fractor\Caching\ValueObject;

final readonly class CacheItem
{
    public function __construct(
        private string $variableKey,
        private mixed $data
    ) {
    }

    /**
     * @param mixed[] $properties
     */
    public static function __set_state(array $properties): self
    {
        return new self($properties['variableKey'], $properties['data']);
    }

    public function isVariableKeyValid(string $variableKey): bool
    {
        return $this->variableKey === $variableKey;
    }

    public function getData(): mixed
    {
        return $this->data;
    }
}
