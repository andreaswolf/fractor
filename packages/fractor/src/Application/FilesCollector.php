<?php

declare(strict_types=1);

namespace a9f\Fractor\Application;

use a9f\Fractor\Application\ValueObject\File;

final class FilesCollector
{
    /**
     * @var array<string, File>
     */
    private array $files = [];

    public function addFile(File $file): void
    {
        $this->files[$file->getFilePath()] = $file;
    }

    public function getFileByPath(string $filePath): ?File
    {
        return $this->files[$filePath] ?? null;
    }

    /**
     * @return array<string, File>
     */
    public function getFiles(): array
    {
        return $this->files;
    }
}
