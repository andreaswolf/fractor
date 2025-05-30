<?php

declare(strict_types=1);

namespace a9f\Fractor\Caching\ValueObject\Storage;

use a9f\Fractor\Caching\Contract\ValueObject\Storage\CacheStorageInterface;
use a9f\Fractor\Caching\ValueObject\CacheItem;

/**
 * inspired by https://github.com/phpstan/phpstan-src/blob/560652088406d7461c2c4ad4897784e33f8ab312/src/Cache/MemoryCacheStorage.php
 */
final class MemoryCacheStorage implements CacheStorageInterface
{
    /**
     * @var array<string, CacheItem>
     */
    private array $storage = [];

    public function load(string $key, string $variableKey): mixed
    {
        if (! isset($this->storage[$key])) {
            return null;
        }
        $item = $this->storage[$key];
        if (! $item->isVariableKeyValid($variableKey)) {
            return null;
        }
        return $item->getData();
    }

    public function save(string $key, string $variableKey, mixed $data): void
    {
        $this->storage[$key] = new CacheItem($variableKey, $data);
    }

    public function clean(string $key): void
    {
        if (! isset($this->storage[$key])) {
            return;
        }
        unset($this->storage[$key]);
    }

    public function clear(): void
    {
        $this->storage = [];
    }
}
