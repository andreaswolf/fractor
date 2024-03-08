<?php

namespace a9f\FractorExtensionInstaller;

use Composer\Installer\InstallationManager;
use Composer\Repository\InstalledRepositoryInterface;

class PackagesFileGenerator
{
    public const FILE_TEMPLATE = <<<PHP
<?php

namespace a9f\FractorExtensionInstaller\Generated;

class InstalledPackages {
    public const PACKAGES = %s;

    private function __construct() {}
}
PHP;

    public function __construct(
        private readonly InstalledRepositoryInterface $repository,
        private readonly InstallationManager $installationManager,
        private readonly string $fileToGenerate
    ) {
    }

    public function generate(): void
    {
        $installedPackages = [];
        foreach ($this->repository->getCanonicalPackages() as $package) {
            if ($package->getType() !== 'fractor-extension') {
                continue;
            }

            $path = $this->installationManager->getInstallPath($package);
            $installedPackages[$package->getName()] = [
                'name' => $package->getName(),
                'path' => $path,
                'version' => $package->getFullPrettyVersion(),
            ];
        }
        $installedPackagesCode = var_export($installedPackages, true);

        file_put_contents(
            $this->fileToGenerate,
            sprintf(self::FILE_TEMPLATE, $installedPackagesCode)
        );
    }
}
