<?php

declare(strict_types=1);

namespace a9f\Fractor\FileSystem\Skipper;

final class FnMatchPathNormalizer
{
    public static function normalizeForFnmatch(string $path): string
    {
        if (str_ends_with($path, '*') || str_starts_with($path, '*')) {
            return '*' . trim($path, '*') . '*';
        }

        if (\str_contains($path, '..')) {
            /** @var string|false $realPath */
            $realPath = realpath($path);
            if ($realPath === false) {
                return '';
            }

            return FilePathNormalizer::normalizeDirectorySeparator($realPath);
        }

        return $path;
    }
}
