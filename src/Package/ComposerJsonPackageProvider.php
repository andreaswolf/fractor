<?php

declare(strict_types=1);

namespace a9f\FractorMonorepo\Package;

use Nette\Utils\Json;

final readonly class ComposerJsonPackageProvider
{
    public function __construct(
        private ComposerJsonPackageFinder $composerJsonPackageFinder
    ) {
    }

    public function resolvePackagesJson(string $packageDirectory): string
    {
        $composerJsonFiles = $this->composerJsonPackageFinder->getPackageComposerFiles($packageDirectory);

        $packages = [];
        foreach ($composerJsonFiles as $composerJsonFile) {
            $composerJson = Json::decode($composerJsonFile->getContents(), true);

            $localPath = basename($composerJsonFile->getPath());

            $splitRepository = $composerJson['extra']['split-repository'] ?? $localPath;

            $packages[] = [
                'local_path' => $localPath,
                'split_repository' => $splitRepository,
            ];
        }

        return Json::encode($packages);
    }
}
