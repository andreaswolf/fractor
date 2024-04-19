<?php

declare(strict_types=1);

namespace a9f\Fractor\Tests\Differ\Formatter\ColorConsoleDiffFormatter;

use a9f\Fractor\Differ\Formatter\ColorConsoleDiffFormatter;
use Iterator;
use Nette\Utils\FileSystem;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class ColorConsoleDiffFormatterTest extends TestCase
{
    private ColorConsoleDiffFormatter $subject;

    protected function setUp(): void
    {
        $this->subject = new ColorConsoleDiffFormatter();
    }

    #[DataProvider('provideData')]
    public function test(string $content, string $expectedFormatedFileContent): void
    {
        $formattedContent = $this->subject->format($content);

        $this->assertStringEqualsFile($expectedFormatedFileContent, $formattedContent);
    }

    public static function provideData(): Iterator
    {
        yield ['...', __DIR__ . '/Source/expected/expected.txt'];
        yield ["-old\n+new", __DIR__ . '/Source/expected/expected_old_new.txt'];

        yield [
            FileSystem::read(__DIR__ . '/Fixture/with_full_diff_by_phpunit.diff'),
            __DIR__ . '/Fixture/expected_with_full_diff_by_phpunit.diff',
        ];
    }
}
