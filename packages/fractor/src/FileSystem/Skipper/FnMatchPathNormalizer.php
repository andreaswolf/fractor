<?php

declare(strict_types=1);

namespace a9f\Fractor\FileSystem\Skipper;

final class FnMatchPathNormalizer
{
    public static function normalizeForFnmatch(string $path): string
    {
        if (substr_compare($path, '*', -strlen('*')) === 0 || strncmp($path, '*', strlen('*')) === 0) {
            return '*' . trim($path, '*') . '*';
        }

        if (strpos($path, '..') !== false) {
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
