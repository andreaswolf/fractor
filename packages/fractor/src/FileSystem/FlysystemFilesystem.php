<?php

declare(strict_types=1);

namespace a9f\Fractor\FileSystem;

use a9f\Fractor\Contract\FilesystemInterface;
use League\Flysystem\DirectoryListing;
use League\Flysystem\FilesystemOperator;
use League\Flysystem\FilesystemReader;
use League\Flysystem\UnableToDeleteFile;
use League\Flysystem\UnableToReadFile;
use League\Flysystem\UnableToWriteFile;

final readonly class FlysystemFilesystem implements FilesystemInterface
{
    public function __construct(
        private FilesystemOperator $filesystemOperator
    ) {
    }

    public function write(string $location, string $contents, array $config = []): void
    {
        try {
            $this->filesystemOperator->write($location, $contents, $config);
        } catch (UnableToWriteFile $e) {
            throw new \RuntimeException(sprintf('Failed to write file "%s": %s', $location, $e->getMessage()), 0, $e);
        }
    }

    public function fileExists(string $location): bool
    {
        return $this->filesystemOperator->fileExists($location);
    }

    public function read(string $location): string
    {
        try {
            return $this->filesystemOperator->read($location);
        } catch (UnableToReadFile $e) {
            throw new \RuntimeException(sprintf('Failed to read file "%s": %s', $location, $e->getMessage()), 0, $e);
        }
    }

    public function move(string $source, string $destination, array $config = []): void
    {
        $this->filesystemOperator->move($source, $destination, $config);
    }

    public function listContents(string $location, bool $deep = FilesystemReader::LIST_SHALLOW): DirectoryListing
    {
        return $this->filesystemOperator->listContents($location, $deep);
    }

    public function appendToFile(string $location, string $content): void
    {
        $existingContent = $this->read($location);

        $existingContent .= PHP_EOL . $content;

        $this->write($location, $existingContent);
    }

    public function delete(string $location): void
    {
        try {
            $this->filesystemOperator->delete($location);
        } catch (UnableToDeleteFile $e) {
            throw new \RuntimeException(sprintf('Failed to delete file "%s": %s', $location, $e->getMessage()), 0, $e);
        }
    }
}
