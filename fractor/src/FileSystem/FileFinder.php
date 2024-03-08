<?php

namespace a9f\Fractor\FileSystem;

use Symfony\Component\Finder\Finder;

final class FileFinder
{
    /**
     * @return list<\SplFileInfo>
     */
    public function findFiles(array $directories, array $fileExtensions): array
    {
        $finder = Finder::create()
            ->files()
            // skip empty files
            ->size('> 0')
            ->in($directories);

        if ($fileExtensions !== []) {
            $pattern = sprintf('/(%s)/', implode('|', $fileExtensions));
            $finder->name($pattern);
        }

        $files = [];
        foreach ($finder as $fileInfo) {
            $files[] = $fileInfo;
        }
        return $files;
    }
}
