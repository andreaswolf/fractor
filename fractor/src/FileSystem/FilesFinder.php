<?php

namespace a9f\Fractor\FileSystem;

use Symfony\Component\Finder\Finder;

final readonly class FilesFinder
{
    public function __construct(private FilesystemTweaker $filesystemTweaker, private FileAndDirectoryFilter $fileAndDirectoryFilter)
    {
    }

    /**
     * @param string[] $source
     * @param string[] $suffixes
     * @return string[]
     */
    public function findFiles(array $source, array $suffixes, bool $sortByName = true): array
    {
        $filesAndDirectories = $this->filesystemTweaker->resolveWithFnmatch($source);

        $files = $this->fileAndDirectoryFilter->filterFiles($filesAndDirectories);

        $filteredFilePaths = array_filter(
            $files,
            fn (string $filePath): bool => true // TODO: Add skipper here
        );

        if ($suffixes !== []) {
            $fileWithExtensionsFilter = static function (string $filePath) use ($suffixes): bool {
                $filePathExtension = pathinfo($filePath, PATHINFO_EXTENSION);
                return in_array($filePathExtension, $suffixes, true);
            };
            $filteredFilePaths = array_filter($filteredFilePaths, $fileWithExtensionsFilter);
        }

        $directories = $this->fileAndDirectoryFilter->filterDirectories($filesAndDirectories);
        $filteredFilePathsInDirectories = $this->findInDirectories($directories, $suffixes, $sortByName);

        return [...$filteredFilePaths, ...$filteredFilePathsInDirectories];
    }

    /**
     * @param string[] $directories
     * @param string[] $suffixes
     * @return string[]
     */
    private function findInDirectories(array $directories, array $suffixes, bool $sortByName = true): array
    {
        if ($directories === []) {
            return [];
        }

        $finder = Finder::create()
            ->files()
            // skip empty files
            ->size('> 0')
            ->in($directories);

        if ($sortByName) {
            $finder->sortByName();
        }

        if ($suffixes !== []) {
            $suffixesPattern = $this->normalizeSuffixesToPattern($suffixes);
            $finder->name($suffixesPattern);
        }

        $filePaths = [];
        foreach ($finder as $fileInfo) {
            // getRealPath() function will return false when it checks broken symlinks.
            // So we should check if this file exists or we got broken symlink

            /** @var string|false $path */
            $path = $fileInfo->getRealPath();
            if ($path === false) {
                continue;
            }

            // TODO: Add skipper here

            $filePaths[] = $path;
        }

        return $filePaths;
    }

    /**
     * @param string[] $suffixes
     */
    private function normalizeSuffixesToPattern(array $suffixes): string
    {
        $suffixesPattern = implode('|', $suffixes);
        return '#\.(' . $suffixesPattern . ')$#';
    }
}
