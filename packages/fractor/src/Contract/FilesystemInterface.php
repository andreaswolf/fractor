<?php

declare(strict_types=1);

namespace a9f\Fractor\Contract;

use League\Flysystem\DirectoryListing;
use League\Flysystem\FilesystemReader;
use League\Flysystem\StorageAttributes;

interface FilesystemInterface
{
    /**
     * @param array<string, mixed> $config
     */
    public function write(string $location, string $contents, array $config = []): void;

    public function fileExists(string $location): bool;

    public function read(string $location): string;

    /**
     * @param array<string, mixed> $config
     */
    public function move(string $source, string $destination, array $config = []): void;

    /**
     * @return DirectoryListing<StorageAttributes>
     */
    public function listContents(string $location, bool $deep = FilesystemReader::LIST_SHALLOW): DirectoryListing;

    public function appendToFile(string $location, string $content): void;

    public function delete(string $location): void;
}
