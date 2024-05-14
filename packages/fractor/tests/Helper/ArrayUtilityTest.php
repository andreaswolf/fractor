<?php

declare(strict_types=1);

namespace a9f\Fractor\Tests\Helper;

use a9f\Fractor\Helper\ArrayUtility;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ArrayUtilityTest extends TestCase
{
    /**
     * @param string[] $expectedResult
     */
    #[DataProvider('trimExplodeReturnsCorrectResultDataProvider')]
    #[Test]
    public function trimExplodeReturnsCorrectResult(
        string $delimiter,
        string $testString,
        bool $removeEmpty,
        array $expectedResult
    ): void {
        self::assertSame($expectedResult, ArrayUtility::trimExplode($delimiter, $testString, $removeEmpty));
    }

    /**
     * @return array<string, array{0: string, 1: string, 2: bool, 3: list<string>}>
     */
    public static function trimExplodeReturnsCorrectResultDataProvider(): array
    {
        return [
            'spaces at element start and end' => [
                ',',
                ' a , b , c ,d ,,  e,f,',
                false,
                ['a', 'b', 'c', 'd', '', 'e', 'f', ''],
            ],
            'removes newline' => [',', ' a , b , ' . chr(10) . ' ,d ,,  e,f,', true, ['a', 'b', 'd', 'e', 'f']],
            'removes empty elements' => [',', 'a , b , c , ,d ,, ,e,f,', true, ['a', 'b', 'c', 'd', 'e', 'f']],
            'keeps zero as string' => [
                ',',
                'a , b , c , ,d ,, ,e,f, 0 ,',
                true,
                ['a', 'b', 'c', 'd', 'e', 'f', '0'],
            ],
            'keeps whitespace inside elements' => [
                ',',
                'a , b , c , ,d ,, ,e,f, g h ,',
                true,
                ['a', 'b', 'c', 'd', 'e', 'f', 'g h'],
            ],
            'can use internal regex delimiter as explode delimiter' => [
                '/',
                'a / b / c / /d // /e/f/ g h /',
                true,
                ['a', 'b', 'c', 'd', 'e', 'f', 'g h'],
            ],
            'can use whitespaces as delimiter' => [' ', '* * * * *', true, ['*', '*', '*', '*', '*']],
            'can use words as delimiter' => ['All', 'HelloAllTogether', true, ['Hello', 'Together']],
            'can use word with appended and prepended spaces as delimiter' => [
                ' all   ',
                'Hello all   together',
                true,
                ['Hello', 'together'],
            ],
            'can use word with appended and prepended spaces as delimiter and do not remove empty' => [
                ' all   ',
                'Hello all   together     all      there all       all   are  all    none',
                false,
                ['Hello', 'together', 'there', '', 'are', 'none'],
            ],
            'can use words as delimiter and do not remove empty' => [
                'all  there',
                'Helloall  theretogether  all  there    all  there   are   all  there     none',
                false,
                ['Hello', 'together', '', 'are', 'none'],
            ],
            'can use words as delimiter, remove empty' => [
                'all  there',
                'Helloall  theretogether  all  there    all  there    are   all  there     none',
                true,
                ['Hello', 'together', 'are', 'none'],
            ],
            'can use new line as delimiter' => [
                chr(10),
                "Hello\nall\ntogether",
                true,
                ['Hello', 'all', 'together'],
            ],
            'works with whitespace separator' => [
                "\t",
                " a  b \t c  \t  \t    d  \t  e     \t u j   \t s",
                false,
                ['a  b', 'c', '', 'd', 'e', 'u j', 's'],
            ],
            'works with whitespace separator and remove empty' => [
                "\t",
                " a  b \t c  \t  \t    d  \t  e     \t u j   \t s",
                true,
                ['a  b', 'c', 'd', 'e', 'u j', 's'],
            ],
        ];
    }
}
