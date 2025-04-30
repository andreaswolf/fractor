<?php

declare(strict_types=1);

namespace a9f\Fractor\Caching;

use a9f\Fractor\Caching\Contract\ValueObject\Storage\CacheStorageInterface;

final readonly class Cache
{
    public function __construct(
        private CacheStorageInterface $cacheStorage
    ) {
    }

    /**
     * @param \a9f\Fractor\Caching\Enum\CacheKey::* $variableKey
     * @return mixed|null
     */
    public function load(string $key, string $variableKey): mixed
    {
        return $this->cacheStorage->load($key, $variableKey);
    }

    /**
     * @param \a9f\Fractor\Caching\Enum\CacheKey::* $variableKey
     */
    public function save(string $key, string $variableKey, mixed $data): void
    {
        $this->cacheStorage->save($key, $variableKey, $data);
    }

    public function clear(): void
    {
        $this->cacheStorage->clear();
    }

    public function clean(string $cacheKey): void
    {
        $this->cacheStorage->clean($cacheKey);
    }
}
