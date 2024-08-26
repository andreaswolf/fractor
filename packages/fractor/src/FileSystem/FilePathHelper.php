<?php

declare(strict_types=1);

namespace a9f\Fractor\FileSystem;

use a9f\Fractor\Skipper\FileSystem\PathNormalizer;
use Symfony\Component\Filesystem\Filesystem;
use Webmozart\Assert\Assert;

final readonly class FilePathHelper
{
    public function __construct(
        private Filesystem $filesystem
    ) {
    }

    public function relativePath(string $fileRealPath): string
    {
        if (! $this->filesystem->isAbsolutePath($fileRealPath)) {
            return $fileRealPath;
        }
        return $this->relativeFilePathFromDirectory($fileRealPath, (string) \getcwd());
    }

    private function relativeFilePathFromDirectory(string $fileRealPath, string $directory): string
    {
        Assert::directory($directory);
        $normalizedFileRealPath = PathNormalizer::normalize($fileRealPath);
        $relativeFilePath = $this->filesystem->makePathRelative($normalizedFileRealPath, $directory);
        return \rtrim($relativeFilePath, '/');
    }
}
