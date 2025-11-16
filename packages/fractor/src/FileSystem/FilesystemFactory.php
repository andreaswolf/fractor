<?php

declare(strict_types=1);

namespace a9f\Fractor\FileSystem;

use a9f\Fractor\Testing\PHPUnit\StaticPHPUnitEnvironment;
use League\Flysystem\Filesystem;
use League\Flysystem\InMemory\InMemoryFilesystemAdapter;
use League\Flysystem\Local\LocalFilesystemAdapter;

final readonly class FilesystemFactory
{
    public function __construct(
        private string $projectDir
    ) {
    }

    public function create(): FlysystemFilesystem
    {
        $argv = $_SERVER['argv'] ?? [];
        $isDryRun = in_array('--dry-run', $argv, true) || in_array('-n', $argv, true);

        if ($isDryRun || StaticPHPUnitEnvironment::isPHPUnitRun()) {
            $adapter = new InMemoryFilesystemAdapter();
        } else {
            $adapter = new LocalFilesystemAdapter($this->projectDir);
        }

        return new FlysystemFilesystem(new Filesystem($adapter));
    }

    public function createLocalFilesystem(): FlysystemFilesystem
    {
        if (StaticPHPUnitEnvironment::isPHPUnitRun()) {
            $adapter = new InMemoryFilesystemAdapter();
        } else {
            $adapter = new LocalFilesystemAdapter($this->projectDir);
        }

        return new FlysystemFilesystem(new Filesystem($adapter));
    }
}
