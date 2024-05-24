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
        self::assertSame(
            ['html', 'xml', 'txt', 'yaml', 'yml'],
            array_values($allowedFileExtensionsResolver->resolve())
        );
    }

    protected function additionalConfigurationFiles(): array
    {
        return [__DIR__ . '/config/config.php'];
    }
}
