<?php

declare(strict_types=1);

use a9f\FractorMonorepo\Package\ComposerJsonPackageFinder;
use a9f\FractorMonorepo\Package\ComposerJsonPackageProvider;
use a9f\FractorMonorepo\Package\PackageDirectoryProvider;

require_once __DIR__ . '/../vendor/autoload.php';

$composerJsonPackageProvider = new ComposerJsonPackageProvider(new ComposerJsonPackageFinder());
$packageDirectoryProvider = new PackageDirectoryProvider();

echo $composerJsonPackageProvider->resolvePackagesJson($packageDirectoryProvider->getPackageDirectory());
