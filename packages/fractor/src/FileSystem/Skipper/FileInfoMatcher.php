<?php

declare(strict_types=1);

namespace a9f\Fractor\FileSystem\Skipper;

final class FileInfoMatcher
{
    /**
     * @readonly
     */
    private FnMatchMatcher $fnMatcher;

    /**
     * @readonly
     */
    private RealpathMatcher $realpathMatcher;

    public function __construct(FnMatchMatcher $fnMatcher, RealpathMatcher $realpathMatcher)
    {
        $this->fnMatcher = $fnMatcher;
        $this->realpathMatcher = $realpathMatcher;
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

        if (strncmp($filePath, $ignoredPath, strlen($ignoredPath)) === 0) {
            return true;
        }

        if (substr_compare($filePath, $ignoredPath, -strlen($ignoredPath)) === 0) {
            return true;
        }

        if ($this->fnMatcher->match($ignoredPath, $filePath)) {
            return true;
        }

        return $this->realpathMatcher->match($ignoredPath, $filePath);
    }
}
