<?php

declare(strict_types=1);

namespace a9f\FractorMonorepo\Composer\Scripts;

use a9f\FractorExtensionInstaller\PackagesFileGenerator;
use a9f\FractorMonorepo\Package\ComposerJsonPackageFinder;
use a9f\FractorMonorepo\Package\FractorExtensionPackageProvider;
use a9f\FractorMonorepo\Package\PackageDirectoryProvider;
use Composer\Script\Event;

final class FractorPackageInstaller
{
    public static function generate(Event $event): void
    {
        $fractorExtensionProvider = new FractorExtensionPackageProvider(new ComposerJsonPackageFinder());
        $packageDirectoryProvider = new PackageDirectoryProvider();
        PackagesFileGenerator::write(
            $fractorExtensionProvider->find($packageDirectoryProvider->getPackageDirectory()),
            __DIR__ . '/../../../packages/extension-installer/generated/InstalledPackages.php'
        );
    }
}
