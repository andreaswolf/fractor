<?php

declare(strict_types=1);

namespace a9f\Typo3Fractor\Tests\TYPO3v10\Yaml\EmailFinisherYamlFractor;

use a9f\Fractor\Testing\PHPUnit\AbstractFractorTestCase;
use Iterator;
use PHPUnit\Framework\Attributes\DataProvider;

final class EmailFinisherYamlFractorTest extends AbstractFractorTestCase
{
    #[DataProvider('provideData')]
    public function test(string $filePath): void
    {
        $this->doTestFile($filePath);
    }

    public static function provideData(): Iterator
    {
        return self::yieldFilesFromDirectory(__DIR__ . '/Fixtures', '*.yaml.fixture');
    }

    public function provideConfigFilePath(): string
    {
        return __DIR__ . '/config/fractor.php';
    }
}
