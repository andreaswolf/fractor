<?php

declare(strict_types=1);

namespace a9f\Fractor\Configuration\ValueObject;

use Webmozart\Assert\Assert;

final readonly class Configuration
{
    /**
     * @param string[] $fileExtensions
     * @param list<non-empty-string> $paths
     * @param string[] $skip
     */
    public function __construct(private array $fileExtensions, private array $paths, private array $skip)
    {
        Assert::allStringNotEmpty($this->paths, 'No directories given');
    }

    /**
     * @return string[]
     */
    public function getFileExtensions(): array
    {
        return $this->fileExtensions;
    }

    /**
     * @return string[]
     */
    public function getSkip(): array
    {
        return $this->skip;
    }

    /**
     * @return list<non-empty-string>
     */
    public function getPaths(): array
    {
        return $this->paths;
    }
}
