<?php
declare(strict_types=1);

namespace a9f\Fractor\FileSystem;

use a9f\Fractor\ValueObject\File;

final class FileCollector
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

    public function getFiles(): array
    {
        return $this->files;
    }
}