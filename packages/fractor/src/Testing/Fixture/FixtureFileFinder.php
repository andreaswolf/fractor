<?php

declare(strict_types=1);

namespace a9f\Fractor\Testing\Fixture;

use Iterator;
use Symfony\Component\Finder\Finder;

final class FixtureFileFinder
{
    /**
     * @api used in tests
     * @return Iterator<array<int, string>>
     */
    public static function yieldDirectory(string $directory, string $suffix): Iterator
    {
        $finder = (new Finder())
            ->in($directory)
            ->files()
            ->ignoreDotFiles(false)
            ->name($suffix)
            ->sortByName();

        foreach ($finder as $fileInfo) {
            yield [$fileInfo->getRealPath()];
        }
    }
}
