<?php

declare(strict_types=1);

namespace a9f\Fractor\Tests\Helper;

use a9f\Fractor\Helper\StringUtility;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class StringUtilityTest extends TestCase
{
    #[DataProvider('inListForItemContainedReturnsTrueDataProvider')]
    #[Test]
    public function inListForItemContainedReturnsTrue(string $haystack): void
    {
        self::assertTrue(StringUtility::inList($haystack, 'findme'));
    }

    /**
     * Data provider for inListForItemContainedReturnsTrue.
     * @return array<string, array<string>>
     */
    public static function inListForItemContainedReturnsTrueDataProvider(): array
    {
        return [
            'Element as second element of four items' => ['one,findme,three,four'],
            'Element at beginning of list' => ['findme,one,two'],
            'Element at end of list' => ['one,two,findme'],
            'One item list' => ['findme'],
        ];
    }

    #[DataProvider('inListForItemNotContainedReturnsFalseDataProvider')]
    #[Test]
    public function inListForItemNotContainedReturnsFalse(string $haystack): void
    {
        self::assertFalse(StringUtility::inList($haystack, 'findme'));
    }

    /**
     * Data provider for inListForItemNotContainedReturnsFalse.
     * @return array<string, array<string>>
     */
    public static function inListForItemNotContainedReturnsFalseDataProvider(): array
    {
        return [
            'Four item list' => ['one,two,three,four'],
            'One item list' => ['one'],
            'Empty list' => [''],
        ];
    }
}
