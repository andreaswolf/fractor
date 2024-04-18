<?php

declare(strict_types=1);

namespace a9f\Fractor\ValueObject;

final class File
{
    private bool $hasChanged = false;
    private readonly string $originalContent;

    public function __construct(private readonly string $filePath, private string $content)
    {
        $this->originalContent = $this->content;
    }

    public function getFilePath(): string
    {
        return $this->filePath;
    }

    public function getDirectoryName(): string
    {
        return dirname($this->filePath);
    }

    public function getFileName(): string
    {
        return basename($this->filePath);
    }

    public function getContent(): string
    {
        return $this->content;
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
}
