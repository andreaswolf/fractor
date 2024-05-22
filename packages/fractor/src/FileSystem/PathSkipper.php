<?php

declare(strict_types=1);

namespace a9f\Fractor\FileSystem;

use a9f\Fractor\FileSystem\Skipper\FileInfoMatcher;
use a9f\Fractor\FileSystem\Skipper\SkippedPathsResolver;

final readonly class PathSkipper
{
    public function __construct(
        private FileInfoMatcher $fileInfoMatcher,
        private SkippedPathsResolver $skippedPathsResolver
    ) {
    }

    /**
     * Decides if a path should be skipped, based on the configured skip patterns.
     */
    public function shouldSkip(string $filePath): bool
    {
        $skippedPaths = $this->skippedPathsResolver->resolve();
        return $this->fileInfoMatcher->doesFilePathMatchAnyPattern($filePath, $skippedPaths);
    }
}
