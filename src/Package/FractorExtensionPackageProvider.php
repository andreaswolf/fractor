<?php

declare(strict_types=1);

namespace a9f\FractorMonorepo\Package;

use Nette\Utils\Json;

final readonly class FractorExtensionPackageProvider
{
    public function __construct(
        private ComposerJsonPackageFinder $composerJsonPackageFinder
    ) {
    }

    /**
     * @return array<string, array{'path': string}>
     */
    public function find(string $packagesDirectory): array
    {
        $installedPackages = [];

        $composerJsonFiles = $this->composerJsonPackageFinder->getPackageComposerFiles($packagesDirectory);

        foreach ($composerJsonFiles as $composerJsonFile) {
            $composerJson = Json::decode($composerJsonFile->getContents(), true);

            if (! array_key_exists('type', $composerJson)) {
                continue;
            }

            if ((string) $composerJson['type'] !== 'fractor-extension') {
                continue;
            }

            $installedPackages[(string) $composerJson['name']] = [
                'path' => $composerJsonFile->getPath(),
            ];
        }

        return $installedPackages;
    }
}
