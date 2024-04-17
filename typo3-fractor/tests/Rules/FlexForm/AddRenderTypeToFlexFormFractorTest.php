<?php

namespace a9f\Typo3Fractor\Tests\Rules\FlexForm;

use a9f\Fractor\Testing\PHPUnit\AbstractFractorTestCase;

class AddRenderTypeToFlexFormFractorTest extends AbstractFractorTestCase
{
    public function test(): void
    {
        // Act
        $this->doTest();

        // Arrange
        $file = $this->fileCollector->getFileByPath(__DIR__ . '/Fixture/SelectWithoutRenderTypeNotInFlexForm.xml');
        self::assertNotNull($file);
        self::assertStringEqualsFile(__DIR__ . '/Fixture/SelectWithoutRenderTypeNotInFlexForm.xml', $file->getContent());

        $file = $this->fileCollector->getFileByPath(__DIR__ . '/Fixture/SelectWithoutRenderType.xml');
        self::assertNotNull($file);
        self::assertStringEqualsFile(__DIR__ . '/Assertions/SelectWithoutRenderType.xml', $file->getContent());
    }

    protected function additionalConfigurationFiles(): array
    {
        return [
            __DIR__ . '/../../../../fractor-xml/config/application.php',
            __DIR__ . '/../../../config/application.php',
            __DIR__ . '/config/application.php',
        ];
    }
}
