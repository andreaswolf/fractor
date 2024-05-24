<?php

declare(strict_types=1);

namespace a9f\FractorMonorepo\Package;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

final class ComposerJsonPackageFinder
{
    /**
     * @var SplFileInfo[]
     */
    private array $cachedPackageComposerFiles = [];

    /**
     * @return SplFileInfo[]
     */
    public function getPackageComposerFiles(string $packagesDirectory): array
    {
        if ($this->cachedPackageComposerFiles === []) {
            $finder = Finder::create()
                ->files()
                ->in($packagesDirectory)
                ->depth(1)
                ->sortByName()
                ->name('composer.json');

            $composerFiles = [];

            foreach ($finder as $file) {
                $composerFiles[] = $file;
            }

            $this->cachedPackageComposerFiles = $composerFiles;
        }
        return $this->cachedPackageComposerFiles;
    }
}
