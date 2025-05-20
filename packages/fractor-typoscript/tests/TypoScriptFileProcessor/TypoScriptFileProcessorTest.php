<?php

declare(strict_types=1);

namespace a9f\FractorTypoScript\Tests\TypoScriptFileProcessor;

use a9f\Fractor\Testing\PHPUnit\AbstractFractorTestCase;
use a9f\FractorTypoScript\Contract\TypoScriptFractor;
use a9f\FractorTypoScript\Tests\Fixtures\DummyTypoScriptFractorRule;
use a9f\FractorTypoScript\Tests\Fixtures\ReturnMultipleStatementsRule;
use PHPUnit\Framework\Attributes\DataProvider;

class TypoScriptFileProcessorTest extends AbstractFractorTestCase
{
    /**
     * @param class-string<TypoScriptFractor> $expectedRule
     */
    #[DataProvider('provideData')]
    public function test(string $filePath, string $expectedRule): void
    {
        $this->doTestFile($filePath);
        $this->assertThatRuleIsApplied($expectedRule);
    }

    public static function provideData(): \Iterator
    {
        yield 'simple dummy TS fractor' => [
            __DIR__ . '/Fixtures/fixture.typoscript.fixture',
            DummyTypoScriptFractorRule::class,
        ];
        yield 'TS fractor returning multiple results' => [
            __DIR__ . '/Fixtures/multipleStatements.typoscript.fixture',
            ReturnMultipleStatementsRule::class,
        ];
    }

    public function provideConfigFilePath(): string
    {
        return __DIR__ . '/config/fractor.php';
    }
}
