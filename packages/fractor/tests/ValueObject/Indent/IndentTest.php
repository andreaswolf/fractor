<?php

declare(strict_types=1);

namespace a9f\Fractor\Tests\ValueObject\Indent;

use a9f\Fractor\Application\ValueObject\File;
use a9f\Fractor\ValueObject\Indent;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class IndentTest extends TestCase
{
    /**
     * @dataProvider
     */
    #[DataProvider('provideValidFiles')]
    public function testFromFile(string $expected, File $file): void
    {
        $indent = Indent::fromFile($file);
        self::assertSame($expected, $indent->toString());
    }

    public function testIsSpaceReturnsTrue(): void
    {
        self::assertTrue(Indent::fromFile(self::fileWithSpaces())->isSpace());
    }

    public function testLengthReturnsCorrectValue(): void
    {
        self::assertSame(2, Indent::fromFile(self::fileWithSpaces())->length());
    }

    public function testIsSpaceReturnsFalse(): void
    {
        self::assertFalse(Indent::fromFile(self::fileWithTabs())->isSpace());
    }

    /**
     * @return \Generator<array<string>>
     */
    public function provideValidStringValues(): \Generator
    {
        yield 'Tabs' => ["\t", "\t"];
        yield 'Spaces' => [' ', ' '];
    }

    /**
     * @return \Generator<array<int, File|string>>
     */
    public static function provideValidFiles(): \Generator
    {
        yield 'File with tab content' => ["\t", self::fileWithTabs()];
        yield 'File with two spaces content' => ['  ', self::fileWithSpaces()];
    }

    private static function fileWithSpaces(): File
    {
        return new File('foobar.txt', (string) file_get_contents(__DIR__ . '/Fixtures/file-with-spaces.txt'));
    }

    private static function fileWithTabs(): File
    {
        return new File('foobar.txt', (string) file_get_contents(__DIR__ . '/Fixtures/tabs.txt'));
    }
}
