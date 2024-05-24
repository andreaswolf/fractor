<?php
declare(strict_types=1);

namespace a9f\FractorMonorepo\Tests\Package;

use a9f\FractorMonorepo\Package\ComposerJsonPackageFinder;
use PHPUnit\Framework\TestCase;

final class ComposerJsonPackageFinderTest extends TestCase
{
    private ComposerJsonPackageFinder $subject;

    protected function setUp(): void
    {
        $this->subject = new ComposerJsonPackageFinder();
    }

    public function test(): void
    {
        // Act
        $composerJsonFiles = $this->subject->getPackageComposerFiles(__DIR__ . '/Fixtures/packages');

        // Assert
        self::assertCount(3, $composerJsonFiles);
    }
}
