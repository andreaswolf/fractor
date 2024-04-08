<?php

namespace a9f\Fractor\FileSystem;

use Symfony\Component\Finder\Finder;

final class FileFinder
{
    /**
     * @param list<non-empty-string> $directories
     * @param list<non-empty-string> $fileExtensions
     * @return list<\SplFileInfo>
     */
    public function findFiles(array $directories, array $fileExtensions): array
    {
        if ($directories === []) {
            throw new \UnexpectedValueException('Directories must not be an empty array');
        }

        $finder = Finder::create()
            ->files()
            // skip empty files
            ->size('> 0')
            ->in($directories);

        foreach ($fileExtensions as $fileExtension) {
            $finder->name('*.' . $fileExtension);
        }

        $files = [];
        foreach ($finder as $fileInfo) {
            $files[] = $fileInfo;
        }
        return $files;
    }
}
