<?php

declare(strict_types=1);

namespace a9f\Fractor\Tests\Configuration\AllowedFileExtensionsResolver;

use a9f\Fractor\Configuration\AllowedFileExtensionsResolver;
use a9f\Fractor\Testing\PHPUnit\AbstractFractorTestCase;

final class AllowedFileExtensionsResolverTest extends AbstractFractorTestCase
{
    public function test(): void
    {
        // Arrange
        $allowedFileExtensionsResolver = $this->getService(AllowedFileExtensionsResolver::class);

        // Act & Assert
        $allowedFileExtensions = $allowedFileExtensionsResolver->resolve();

        self::assertContains('yaml', $allowedFileExtensions);
        self::assertContains('yml', $allowedFileExtensions);
        self::assertContains('json', $allowedFileExtensions);
        self::assertContains('xml', $allowedFileExtensions);
        self::assertContains('html', $allowedFileExtensions);
        self::assertContains('txt', $allowedFileExtensions);
    }

    protected function additionalConfigurationFiles(): array
    {
        return [__DIR__ . '/config/config.php'];
    }
}
