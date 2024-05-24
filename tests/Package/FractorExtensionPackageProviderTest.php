<?php
declare(strict_types=1);

namespace a9f\FractorMonorepo\Tests\Package;

use a9f\FractorMonorepo\Package\ComposerJsonPackageFinder;
use a9f\FractorMonorepo\Package\FractorExtensionPackageProvider;
use PHPUnit\Framework\TestCase;

final class FractorExtensionPackageProviderTest extends TestCase
{
    private FractorExtensionPackageProvider $subject;

    protected function setUp(): void
    {
        $this->subject = new FractorExtensionPackageProvider(new ComposerJsonPackageFinder());
    }

    public function test(): void
    {
        // Act
        $installedPackages = $this->subject->find(__DIR__ . '/Fixtures/packages');

        // Assert
        self::assertCount(2, $installedPackages);
        self::assertSame([
            'package/package-1' =>  [
                'path' => __DIR__ . '/Fixtures/packages/package1'
            ],
            'package/package-2' => [
                'path' => __DIR__ . '/Fixtures/packages/package2',
            ],
        ], $installedPackages);
    }
}
