<?php

declare(strict_types=1);

namespace a9f\Fractor\Tests\Skipper\FileSystem\FilePathHelper;

use a9f\Fractor\Skipper\FileSystem\FilePathHelper;
use Iterator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;

final class FilePathHelperTest extends TestCase
{
    private FilePathHelper $subject;

    protected function setUp(): void
    {
        $this->subject = new FilePathHelper(new Filesystem());
    }

    #[DataProvider('provideData')]
    public function test(string $inputPath, string $expectedNormalizedPath): void
    {
        $normalizedPath = $this->subject->normalizePathAndSchema($inputPath);
        $this->assertSame($expectedNormalizedPath, $normalizedPath);
    }

    public static function provideData(): Iterator
    {
        // based on Linux
        yield ['/any/path', '/any/path'];
        yield ['\any\path', '/any/path'];
    }
}
