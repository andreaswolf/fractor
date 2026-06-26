<?php

declare(strict_types=1);

namespace a9f\Fractor\Configuration\ValueObject;

use a9f\Fractor\ChangesReporting\Output\ConsoleOutputFormatter;
use Webmozart\Assert\Assert;

/**
 * This is class is created on runtime and cannot be injected via Dependency Injection
 */
final readonly class Configuration
{
    /**
     * @param string[] $fileExtensions
     * @param list<non-empty-string> $paths
     */
    public function __construct(
        private bool $dryRun = false,
        private bool $showProgressBar = true,
        private string $outputFormat = ConsoleOutputFormatter::NAME,
        private array $fileExtensions = [],
        private array $paths = [],
        private bool $showDiffs = true,
        private string|null $memoryLimit = null,
        private ?string $onlyRule = null,
        private bool $showChangelog = false,
    ) {
        Assert::allStringNotEmpty($this->paths, 'No directories given');
    }

    public function isDryRun(): bool
    {
        return $this->dryRun;
    }

    public function shouldShowProgressBar(): bool
    {
        return $this->showProgressBar;
    }

    public function getOutputFormat(): string
    {
        return $this->outputFormat;
    }

    /**
     * @return string[]
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

    public function shouldShowDiffs(): bool
    {
        return $this->showDiffs;
    }

    public function getMemoryLimit(): ?string
    {
        return $this->memoryLimit;
    }

    public function getOnlyRule(): ?string
    {
        return $this->onlyRule;
    }

    public function shouldShowChangelog(): bool
    {
        return $this->showChangelog;
    }
}
