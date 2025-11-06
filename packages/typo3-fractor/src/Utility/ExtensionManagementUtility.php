<?php

declare(strict_types=1);

namespace a9f\Typo3Fractor\Utility;

use a9f\Fractor\Contract\LocalFilesystemInterface;

final readonly class ExtensionManagementUtility
{
    public function __construct(
        private LocalFilesystemInterface $filesystem
    ) {
    }

    /**
     * Resolve the extension root path from an absolute path by finding either composer.json or ext_emconf.php
     */
    public function resolveExtensionPath(string $path): string
    {
        // Normalize the starting path and resolve symbolic links, '.', '..'
        $currentPath = realpath($path);

        if ($currentPath === false) {
            throw new \InvalidArgumentException('Invalid starting path provided: ' . $path);
        }

        // If $startPath was a file, begin the search in its directory.
        // If $startPath was a directory, realpath() would have returned its absolute path,
        // so we can use it directly.
        if (is_file($currentPath)) {
            $currentPath = dirname($currentPath);
        }

        $resolvedPackagePath = null;
        $previousPath = null; // To detect when we've reached the root or are stuck

        while ($currentPath && $currentPath !== $previousPath) {
            $composerJsonFullPath = $currentPath . DIRECTORY_SEPARATOR . 'composer.json';
            $extEmconfFullPath = $currentPath . DIRECTORY_SEPARATOR . 'ext_emconf.php';

            if ($this->filesystem->fileExists($composerJsonFullPath)) {
                $resolvedPackagePath = $currentPath;
                break;
            }

            if ($this->filesystem->fileExists($extEmconfFullPath)) {
                $resolvedPackagePath = $currentPath;
                break;
            }

            $previousPath = $currentPath;
            $currentPath = dirname($currentPath);
        }

        if ($resolvedPackagePath === null) {
            throw new \RuntimeException(
                'Neither composer.json nor ext_emconf.php found in the parent directories of ' . $path
            );
        }

        return $resolvedPackagePath;
    }
}
