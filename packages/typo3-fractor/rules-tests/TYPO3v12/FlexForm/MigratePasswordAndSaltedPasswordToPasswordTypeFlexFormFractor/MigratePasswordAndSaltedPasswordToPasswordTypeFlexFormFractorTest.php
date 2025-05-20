<?php

declare(strict_types=1);

namespace a9f\Typo3Fractor\Tests\TYPO3v12\FlexForm\MigratePasswordAndSaltedPasswordToPasswordTypeFlexFormFractor;

use a9f\Fractor\Testing\PHPUnit\AbstractFractorTestCase;
use PHPUnit\Framework\Attributes\DataProvider;

final class MigratePasswordAndSaltedPasswordToPasswordTypeFlexFormFractorTest extends AbstractFractorTestCase
{
    #[DataProvider('provideData')]
    public function test(string $filePath): void
    {
        $this->doTestFile($filePath);
    }

    public static function provideData(): \Iterator
    {
        return self::yieldFilesFromDirectory(__DIR__ . '/Fixtures', '*.xml.fixture');
    }

    public function provideConfigFilePath(): string
    {
        return __DIR__ . '/config/fractor.php';
    }
}
