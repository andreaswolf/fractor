<?php

declare(strict_types=1);

namespace a9f\Fractor\FileSystem;

use a9f\Fractor\Caching\UnchangedFilesFilter;
use Symfony\Component\Finder\Finder;
use Webmozart\Assert\Assert;

final readonly class FilesFinder
{
    public function __construct(
        private WildcardResolver $wildcardResolver,
        private FileAndDirectoryFilter $fileAndDirectoryFilter,
        private PathSkipper $pathSkipper,
        private UnchangedFilesFilter $unchangedFilesFilter
    ) {
    }

    /**
     * @param list<non-empty-string> $source
     * @param string[] $suffixes
     * @return string[]
     */
    public function findFiles(array $source, array $suffixes, bool $sortByName = true): array
    {
        Assert::allStringNotEmpty($source, 'Please provide some paths');

        $filesAndDirectories = $this->wildcardResolver->resolveAllWildcards($source);

        $files = $this->fileAndDirectoryFilter->filterFiles($filesAndDirectories);

        $filteredFilePaths = array_filter(
            $files,
            fn (string $filePath): bool => ! $this->pathSkipper->shouldSkip($filePath)
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

        $filePaths = [...$filteredFilePaths, ...$filteredFilePathsInDirectories];
        return $this->unchangedFilesFilter->filterFilePaths($filePaths);
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
            ->ignoreDotFiles(false)
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

            if ($this->pathSkipper->shouldSkip($path)) {
                continue;
            }

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
