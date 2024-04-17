<?php

declare(strict_types=1);

namespace a9f\Fractor\ValueObject;

final readonly class Configuration
{
    /**
     * @param list<non-empty-string> $fileExtensions
     * @param list<non-empty-string> $paths
     */
    public function __construct(private array $fileExtensions, private array $paths)
    {
    }

    /**
     * @return list<non-empty-string>
     */
    public function getFileExtensions(): array
    {
        return $this->fileExtensions;
    }

    /**
     * @return list<non-empty-string>
     */
    public function getPaths(): array
    {
        return $this->paths;
    }
}
