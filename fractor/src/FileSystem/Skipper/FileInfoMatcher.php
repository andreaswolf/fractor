<?php

declare(strict_types=1);

namespace a9f\Fractor\FileSystem\Skipper;

final readonly class FileInfoMatcher
{
    public function __construct(
        private FnmatchMatcher $fnmatcher,
        private RealpathMatcher $realpathMatcher
    ) {
    }

    /**
     * Checks the given path against the given list of patterns, checking for equality, prefix/suffix and checking
     * with {@see fnmatch()} and {@see realpath()}.
     *
     * @param string[] $filePatterns
     */
    public function doesFilePathMatchAnyPattern(string $filePath, array $filePatterns): bool
    {
        $filePath = FilePathNormalizer::normalizeDirectorySeparator($filePath);
        foreach ($filePatterns as $filePattern) {
            $filePattern = FilePathNormalizer::normalizeDirectorySeparator($filePattern);
            if ($this->doesFilePathMatchPattern($filePath, $filePattern)) {
                return true;
            }
        }

        return false;
    }

    private function doesFilePathMatchPattern(string $filePath, string $ignoredPath): bool
    {
        if ($filePath === $ignoredPath) {
            return true;
        }

        $ignoredPath = FnMatchPathNormalizer::normalizeForFnmatch($ignoredPath);
        if ($ignoredPath === '') {
            return false;
        }

        if (str_starts_with($filePath, $ignoredPath)) {
            return true;
        }

        if (str_ends_with($filePath, $ignoredPath)) {
            return true;
        }

        if ($this->fnmatcher->match($ignoredPath, $filePath)) {
            return true;
        }

        return $this->realpathMatcher->match($ignoredPath, $filePath);
    }
}
