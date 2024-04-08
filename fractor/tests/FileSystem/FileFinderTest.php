<?php

declare(strict_types=1);

namespace FileSystem;

use a9f\Fractor\FileSystem\FileFinder;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use UnexpectedValueException;

final class FileFinderTest extends TestCase
{
    private FileFinder $subject;

    protected function setUp(): void
    {
        $this->subject = new FileFinder();
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
        self::assertCount(4, $this->subject->findFiles([__DIR__ . '/Fixture/DirectorToSearchIn'], []));
    }

    #[Test]
    public function findAllNonEmptyFilesInGivenDirectoriesWithGivenExtensions(): void
    {
        self::assertCount(2, $this->subject->findFiles([__DIR__ . '/Fixture/DirectorToSearchIn'], ['txt', 'json']));
    }
}
