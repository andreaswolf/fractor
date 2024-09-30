<?php

declare(strict_types=1);

namespace a9f\Fractor\FileSystem;

use a9f\Fractor\FileSystem\Skipper\FileInfoMatcher;
use a9f\Fractor\FileSystem\Skipper\SkippedPathsResolver;

final class PathSkipper
{
    /**
     * @readonly
     */
    private FileInfoMatcher $fileInfoMatcher;

    /**
     * @readonly
     */
    private SkippedPathsResolver $skippedPathsResolver;

    public function __construct(FileInfoMatcher $fileInfoMatcher, SkippedPathsResolver $skippedPathsResolver)
    {
        $this->fileInfoMatcher = $fileInfoMatcher;
        $this->skippedPathsResolver = $skippedPathsResolver;
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
