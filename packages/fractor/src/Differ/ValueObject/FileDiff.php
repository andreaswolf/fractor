<?php

declare(strict_types=1);

namespace a9f\Fractor\Differ\ValueObject;

final readonly class FileDiff
{
    public function __construct(
        private string $relativeFilePath,
        private string $diff,
        private string $diffConsoleFormatted,
        /** @var string[] $appliedRules */
        private array $appliedRules = []
    ) {
    }

    public function getRelativeFilePath(): string
    {
        return $this->relativeFilePath;
    }

    public function getAbsoluteFilePath(): ?string
    {
        return \realpath($this->relativeFilePath) ?: null;
    }

    public function getDiff(): string
    {
        return $this->diff;
    }

    public function getDiffConsoleFormatted(): string
    {
        return $this->diffConsoleFormatted;
    }

    /**
     * @return string[]
     */
    public function getAppliedRules(): array
    {
        return $this->appliedRules;
    }
}
