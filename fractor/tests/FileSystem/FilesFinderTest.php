<?php

declare(strict_types=1);

namespace a9f\Fractor\Tests\FileSystem;

use a9f\Fractor\FileSystem\FilesFinder;
use a9f\Fractor\Testing\PHPUnit\AbstractFractorTestCase;
use PHPUnit\Framework\Attributes\Test;
use UnexpectedValueException;

final class FilesFinderTest extends AbstractFractorTestCase
{
    private FilesFinder $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = $this->getService(FilesFinder::class);
    }

    #[Test]
    public function anExceptionIsThrownWhenDirectoriesAreEmpty(): void
    {
        $this->expectException(UnexpectedValueException::class);
        $this->subject->findFiles([], []);
    }

    #[Test]
    public function findAllNonEmptyFilesInGivenDirectories(): void
    {
        self::assertCount(4, $this->subject->findFiles([__DIR__ . '/Fixtures/DirectorToSearchIn'], []));
    }

    #[Test]
    public function findAllNonEmptyFilesInGivenDirectoriesWithGivenExtensions(): void
    {
        self::assertCount(2, $this->subject->findFiles([__DIR__ . '/Fixtures/DirectorToSearchIn'], ['txt', 'json']));
    }
}
