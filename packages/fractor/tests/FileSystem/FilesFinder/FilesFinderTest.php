<?php

declare(strict_types=1);

namespace a9f\Fractor\Tests\FileSystem\FilesFinder;

use a9f\Fractor\FileSystem\FilesFinder;
use a9f\Fractor\Testing\PHPUnit\AbstractFractorTestCase;
use PHPUnit\Framework\Attributes\Test;

final class FilesFinderTest extends AbstractFractorTestCase
{
    private FilesFinder $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = $this->getService(FilesFinder::class);
    }

    #[Test]
    public function findAllNonEmptyFilesInGivenDirectories(): void
    {
        self::assertCount(4, $this->subject->findFiles([__DIR__ . '/Fixtures/Source'], []));
    }

    #[Test]
    public function findAllNonEmptyFilesInGivenDirectoriesWithGivenExtensions(): void
    {
        self::assertCount(2, $this->subject->findFiles([__DIR__ . '/Fixtures/Source'], ['txt', 'json']));
    }

    #[Test]
    public function withFollowingBrokenSymlinks(): void
    {
        $foundFiles = $this->subject->findFiles([__DIR__ . '/Fixtures/SourceWithBrokenSymlinks'], []);
        self::assertCount(0, $foundFiles);
    }

    #[Test]
    public function directoriesWithGlobPattern(): void
    {
        $foundDirectories = $this->subject->findFiles([__DIR__ . '/Fixtures/SourceWithSubFolders/folder*/*'], []);
        self::assertCount(2, $foundDirectories);
    }

    #[Test]
    public function filesWithGlobPattern(): void
    {
        $foundFiles = $this->subject->findFiles([__DIR__ . '/Fixtures/SourceWithSubFolders/**/foo.txt'], ['txt']);
        self::assertCount(2, $foundFiles);

        /** @var string $foundFile */
        $foundFile = array_pop($foundFiles);

        $fileBasename = $this->getFileBasename($foundFile);
        self::assertSame('foo.txt', $fileBasename);
    }

    public function provideConfigFilePath(): ?string
    {
        return __DIR__ . '/config/fractor.php';
    }

    private function getFileBasename(string $foundFile): string
    {
        return pathinfo($foundFile, PATHINFO_BASENAME);
    }
}
