<?php

declare(strict_types=1);

namespace a9f\FractorDocGenerator\Tests\Printer\DirectoryToMarkdownPrinter;

use a9f\FractorDocGenerator\Printer\DirectoryToMarkdownPrinter;
use a9f\FractorDocGenerator\Tests\AbstractTestCase;
use PHPUnit\Framework\Attributes\DataProvider;

final class DirectoryToMarkdownPrinterTest extends AbstractTestCase
{
    private DirectoryToMarkdownPrinter $directoryToMarkdownPrinter;

    protected function setUp(): void
    {
        parent::setUp();
        $this->directoryToMarkdownPrinter = $this->getService(DirectoryToMarkdownPrinter::class);
    }

    #[DataProvider('provideData')]
    public function test(string $directory, string $expectedFile): void
    {
        $fileContent = $this->directoryToMarkdownPrinter->print(__DIR__, [$directory]);

        self::assertStringEqualsFile($expectedFile, $fileContent, $directory);
    }

    public static function provideData(): \Iterator
    {
        yield [__DIR__ . '/Fixtures/Fractor/Standard', __DIR__ . '/Assertions/Fractor/Standard/expected.md'];
    }
}
