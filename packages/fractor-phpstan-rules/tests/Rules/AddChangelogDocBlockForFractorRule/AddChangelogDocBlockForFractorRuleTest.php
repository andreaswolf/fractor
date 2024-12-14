<?php

declare(strict_types=1);

namespace a9f\FractorPhpStanRules\Tests\Rules\AddChangelogDocBlockForFractorRule;

use a9f\FractorPhpStanRules\Rules\AddChangelogDocBlockForFractorRule;
use Iterator;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use PHPUnit\Framework\Attributes\DataProvider;

/**
 * @extends RuleTestCase<AddChangelogDocBlockForFractorRule>
 */
final class AddChangelogDocBlockForFractorRuleTest extends RuleTestCase
{
    /**
     * @param list<array{0: string, 1: int, 2?: string|null}> $expectedErrorsWithLines
     */
    #[DataProvider('provideData')]
    public function testRule(string $filePath, array $expectedErrorsWithLines): void
    {
        $this->analyse([$filePath], $expectedErrorsWithLines);
    }

    /**
     * @return Iterator<mixed>
     */
    public static function provideData(): Iterator
    {
        $message = sprintf(AddChangelogDocBlockForFractorRule::ERROR_MESSAGE, 'MissingChangelog');
        yield [__DIR__ . '/Fixture/MissingChangelog.php', [[$message, 10]]];
        yield [__DIR__ . '/Fixture/SkipWithChangelog.php', []];
        yield [__DIR__ . '/Fixture/SkipWithNonRequiredInterface.php', []];
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/../../../config/config.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(AddChangelogDocBlockForFractorRule::class);
    }
}
