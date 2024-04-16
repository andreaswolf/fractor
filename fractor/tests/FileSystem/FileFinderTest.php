<?php

declare(strict_types=1);

namespace a9f\Fractor\Tests\FileSystem;

use a9f\Fractor\FileSystem\FileFinder;
use a9f\Fractor\Testing\PHPUnit\AbstractFractorTestCase;
use PHPUnit\Framework\Attributes\Test;
use UnexpectedValueException;

final class FileFinderTest extends AbstractFractorTestCase
{
    private FileFinder $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = $this->getService(FileFinder::class);
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

    protected function provideConfigFilePath(): ?string
    {
        return null;
    }
}
