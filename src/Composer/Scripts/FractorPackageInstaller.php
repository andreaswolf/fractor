<?php

declare(strict_types=1);

namespace a9f\FractorMonorepo\Composer\Scripts;

use a9f\FractorExtensionInstaller\PackagesFileGenerator;
use Nette\Utils\FileSystem;
use Nette\Utils\Json;

final class FractorPackageInstaller
{
    public static function generate(): void
    {
        $packagesDirectory = __DIR__ . '/../../../packages/';
        $installedPackages = [];
        if ($handle = opendir($packagesDirectory)) {
            while ($package = readdir($handle)) {
                $composerFile = $packagesDirectory . $package . '/composer.json';

                if (! file_exists($composerFile)) {
                    continue;
                }

                $composerJsonContent = FileSystem::read($composerFile);

                $composerJson = Json::decode($composerJsonContent, true);

                if (! array_key_exists('type', $composerJson)) {
                    continue;
                }

                if ((string) $composerJson['type'] !== 'fractor-extension') {
                    continue;
                }

                $installedPackages[(string) $composerJson['name']] = [
                    'path' => dirname($composerFile),
                ];
            }

            closedir($handle);
        }
        PackagesFileGenerator::write(
            $installedPackages,
            __DIR__ . '/../../../packages/extension-installer/generated/InstalledPackages.php'
        );
    }
}
