<?php

declare(strict_types=1);

namespace a9f\Fractor\FileSystem\Skipper;

final class RealpathMatcher
{
    public function match(string $matchingPath, string $filePath): bool
    {
        $realPathMatchingPath = realpath($matchingPath);
        if ($realPathMatchingPath === false) {
            return false;
        }

        $realpathFilePath = realpath($filePath);
        if ($realpathFilePath === false) {
            return false;
        }

        $normalizedMatchingPath = FilePathNormalizer::normalizeDirectorySeparator($realPathMatchingPath);
        $normalizedFilePath = FilePathNormalizer::normalizeDirectorySeparator($realpathFilePath);

        // skip define direct path
        if (is_file($normalizedMatchingPath)) {
            return $normalizedMatchingPath === $normalizedFilePath;
        }

        // ensure add / suffix to ensure no same prefix directory
        if (is_dir($normalizedMatchingPath)) {
            $normalizedMatchingPath = rtrim($normalizedMatchingPath, '/') . '/';
        }

        return str_starts_with($normalizedFilePath, $normalizedMatchingPath);
    }
}
