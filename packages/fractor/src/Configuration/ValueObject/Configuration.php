<?php

declare(strict_types=1);

namespace a9f\Fractor\Configuration\ValueObject;

use Webmozart\Assert\Assert;

/**
 * This is class is created on runtime and cannot be injected via Dependency Injection
 */
final readonly class Configuration
{
    /**
     * @param string[] $fileExtensions
     * @param list<non-empty-string> $paths
     * @param string[] $skip
     */
    public function __construct(
        private array $fileExtensions,
        private array $paths,
        private array $skip,
        private bool $dryRun,
        private bool $quiet,
        private ?string $onlyRule = null,
    ) {
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

    public function isDryRun(): bool
    {
        return $this->dryRun;
    }

    public function isQuiet(): bool
    {
        return $this->quiet;
    }

    public function getOnlyRule(): ?string
    {
        return $this->onlyRule;
    }
}
