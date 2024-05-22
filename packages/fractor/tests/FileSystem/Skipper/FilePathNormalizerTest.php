<?php

declare(strict_types=1);

namespace a9f\Fractor\Tests\FileSystem\Skipper;

use a9f\Fractor\FileSystem\Skipper\FilePathNormalizer;
use Iterator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class FilePathNormalizerTest extends TestCase
{
    #[DataProvider('provideData')]
    public function test(string $inputPath, string $expectedNormalizedPath): void
    {
        $normalizedPath = FilePathNormalizer::normalizeDirectorySeparator($inputPath);
        $this->assertSame($expectedNormalizedPath, $normalizedPath);
    }

    public static function provideData(): Iterator
    {
        // based on Linux
        yield ['/any/path', '/any/path'];
        yield ['\any\path', '/any/path'];
    }
}
