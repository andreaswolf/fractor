<?php

declare(strict_types=1);

namespace a9f\Fractor\Tests\Reporting\FractorsChangelogLinesResolver;

use a9f\Fractor\Application\ValueObject\AppliedRule;
use a9f\Fractor\Reporting\ChangelogExtractor;
use a9f\Fractor\Reporting\FractorsChangelogLinesResolver;
use a9f\Fractor\Reporting\FractorsChangelogResolver;
use a9f\Fractor\Tests\Fixture\DummyProcessor\Rules\ReplaceXXXTextRule;
use PHPUnit\Framework\TestCase;

final class FractorsChangelogLinesResolverTest extends TestCase
{
    private FractorsChangelogLinesResolver $subject;

    protected function setUp(): void
    {
        $this->subject = new FractorsChangelogLinesResolver(new FractorsChangelogResolver(new ChangelogExtractor()));
    }

    public function test(): void
    {
        // Arrange
        $appliedRules = [
            AppliedRule::fromRule(new ReplaceXXXTextRule())
        ];

        $expected = [
            'ReplaceXXXTextRule (https://docs.typo3.org/c/typo3/cms-core/main/en-us/Changelog-11.html)'
        ];

        // Act & Assert
        self::assertSame($expected, $this->subject->createFractorChangelogLines($appliedRules));
    }
}
