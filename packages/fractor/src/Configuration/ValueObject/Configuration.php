<?php

declare(strict_types=1);

namespace a9f\Fractor\Configuration\ValueObject;

use Webmozart\Assert\Assert;

/**
 * This is class is created on runtime and cannot be injected via Dependency Injection
 */
final class Configuration
{
    /**
     * @var string[]
     * @readonly
     */
    private array $fileExtensions;

    /**
     * @var list<non-empty-string>
     * @readonly
     */
    private array $paths;

    /**
     * @var string[]
     * @readonly
     */
    private array $skip;

    /**
     * @readonly
     */
    private bool $dryRun;

    /**
     * @readonly
     */
    private bool $quiet;

    /**
     * @param string[] $fileExtensions
     * @param list<non-empty-string> $paths
     * @param string[] $skip
     */
    public function __construct(
        array $fileExtensions,
        array $paths,
        array $skip,
        bool $dryRun,
        bool $quiet
    ) {
        $this->fileExtensions = $fileExtensions;
        $this->paths = $paths;
        $this->skip = $skip;
        $this->dryRun = $dryRun;
        $this->quiet = $quiet;
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
}
