<?php

declare(strict_types=1);

namespace a9f\FractorTypoScript\Tests\TypoScriptFileProcessor;

use a9f\Fractor\Testing\PHPUnit\AbstractFractorTestCase;
use a9f\FractorTypoScript\Tests\Fixtures\DummyTypoScriptFractorRule;
use PHPUnit\Framework\Attributes\DataProvider;

class TypoScriptFileProcessorTest extends AbstractFractorTestCase
{
    #[DataProvider('provideData')]
    public function test(string $filePath): void
    {
        $this->doTestFile($filePath);
        $this->assertThatRuleIsApplied($filePath, DummyTypoScriptFractorRule::class);
    }

    public static function provideData(): \Iterator
    {
        return self::yieldFilesFromDirectory(__DIR__ . '/Fixtures', '*.typoscript');
    }

    public function provideConfigFilePath(): ?string
    {
        return __DIR__ . '/config/fractor.php';
    }
}
