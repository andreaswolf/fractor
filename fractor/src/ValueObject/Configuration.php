<?php
declare(strict_types=1);

namespace a9f\Fractor\ValueObject;

final readonly class Configuration
{
    /**
     * @param array<int, string> $fileExtensions
     * @param array<int, string> $paths
     */
    public function __construct(private array $fileExtensions, private array $paths)
    {
    }

    /**
     * @return array<int, string>
     */
    public function getFileExtensions(): array
    {
        return $this->fileExtensions;
    }

    /**
     * @return array<int, string>
     */
    public function getPaths(): array
    {
        return $this->paths;
    }
}