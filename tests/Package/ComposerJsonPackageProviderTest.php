<?php
declare(strict_types=1);

namespace a9f\FractorMonorepo\Tests\Package;

use a9f\FractorMonorepo\Package\ComposerJsonPackageFinder;
use a9f\FractorMonorepo\Package\ComposerJsonPackageProvider;
use PHPUnit\Framework\TestCase;

final class ComposerJsonPackageProviderTest extends TestCase
{
    private ComposerJsonPackageProvider $subject;

    protected function setUp(): void
    {
        $this->subject = new ComposerJsonPackageProvider(new ComposerJsonPackageFinder());
    }

    public function test(): void
    {
        // Act
        $actualJson = $this->subject->resolvePackagesJson(__DIR__. '/Fixtures/packages');

        // Assert
        self::assertJsonStringEqualsJsonFile(__DIR__ . '/Assertions/packages.json', $actualJson);
    }
}
