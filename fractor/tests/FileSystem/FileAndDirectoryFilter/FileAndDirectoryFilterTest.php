<?php

declare(strict_types=1);

namespace a9f\Fractor\Tests\FileSystem\FileAndDirectoryFilter;

use a9f\Fractor\FileSystem\FileAndDirectoryFilter;
use PHPUnit\Framework\TestCase;

final class FileAndDirectoryFilterTest extends TestCase
{
    private FileAndDirectoryFilter $fileAndDirectoryFilter;

    protected function setUp(): void
    {
        $this->fileAndDirectoryFilter = new FileAndDirectoryFilter();
    }

    public function testSeparateFilesAndDirectories(): void
    {
        $sources = [__DIR__, __DIR__ . '/FileAndDirectoryFilterTest.php'];

        $files = $this->fileAndDirectoryFilter->filterFiles($sources);
        $directories = $this->fileAndDirectoryFilter->filterDirectories($sources);

        self::assertCount(1, $files);
        self::assertCount(1, $directories);

        self::assertSame($files, [__DIR__ . '/FileAndDirectoryFilterTest.php']);
        self::assertSame($directories, [__DIR__]);
    }
}
