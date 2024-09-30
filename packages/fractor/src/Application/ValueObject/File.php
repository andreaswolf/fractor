<?php

declare(strict_types=1);

namespace a9f\Fractor\Application\ValueObject;

use a9f\Fractor\Differ\ValueObject\Diff;
use a9f\Fractor\Differ\ValueObject\FileDiff;

final class File
{
    /**
     * @readonly
     */
    private string $filePath;

    private string $content;

    private bool $hasChanged = false;

    private string $originalContent;

    /**
     * @readonly
     */
    private string $directoryName;

    /**
     * @readonly
     */
    private string $fileName;

    /**
     * @readonly
     */
    private string $fileExtension;

    private ?FileDiff $fileDiff = null;

    /**
     * @var AppliedRule[]
     */
    private array $appliedRules = [];

    public function __construct(
        string $filePath,
        string $content
    ) {
        $this->filePath = $filePath;
        $this->content = $content;
        $this->originalContent = $this->content;
        $this->directoryName = dirname($this->filePath);
        $this->fileName = basename($this->filePath);
        $this->fileExtension = pathinfo($this->fileName, PATHINFO_EXTENSION);
    }

    public function changeOriginalContent(string $originalContent): void
    {
        $this->originalContent = $originalContent;
    }

    public function getFilePath(): string
    {
        return $this->filePath;
    }

    public function getDirectoryName(): string
    {
        return $this->directoryName;
    }

    public function getFileName(): string
    {
        return $this->fileName;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getFileExtension(): string
    {
        return $this->fileExtension;
    }

    public function changeFileContent(string $newFileContent): void
    {
        if ($this->content === $newFileContent) {
            return;
        }

        $this->content = $newFileContent;
        $this->hasChanged = true;
    }

    public function hasChanged(): bool
    {
        return $this->hasChanged;
    }

    public function getOriginalContent(): string
    {
        return $this->originalContent;
    }

    public function getDiff(): Diff
    {
        return new Diff($this->originalContent, $this->content);
    }

    public function setFileDiff(FileDiff $fileDiff): void
    {
        $this->fileDiff = $fileDiff;
    }

    public function addAppliedRule(AppliedRule $appliedRule): void
    {
        $this->appliedRules[] = $appliedRule;
    }

    public function getFileDiff(): ?FileDiff
    {
        return $this->fileDiff;
    }

    /**
     * @return AppliedRule[]
     */
    public function getAppliedRules(): array
    {
        return $this->appliedRules;
    }
}
