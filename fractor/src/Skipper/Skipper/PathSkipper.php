<?php

declare(strict_types=1);

namespace a9f\Fractor\Skipper\Skipper;

use a9f\Fractor\Skipper\Matcher\FileInfoMatcher;
use a9f\Fractor\Skipper\SkipCriteriaResolver\SkippedPathsResolver;

final readonly class PathSkipper
{
    public function __construct(
        private FileInfoMatcher $fileInfoMatcher,
        private SkippedPathsResolver $skippedPathsResolver
    ) {
    }

    public function shouldSkip(string $filePath): bool
    {
        $skippedPaths = $this->skippedPathsResolver->resolve();
        return $this->fileInfoMatcher->doesFileInfoMatchPatterns($filePath, $skippedPaths);
    }
}
