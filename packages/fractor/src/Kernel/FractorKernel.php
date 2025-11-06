<?php

declare(strict_types=1);

namespace a9f\Fractor\Kernel;

use a9f\Fractor\Exception\ShouldNotHappenException;
use a9f\Fractor\ValueObject\Bootstrap\BootstrapConfigs;
use a9f\FractorExtensionInstaller\Generated\InstalledPackages;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class FractorKernel
{
    public function createFromConfig(BootstrapConfigs $bootstrapConfigs): ContainerBuilder
    {
        return $this->buildContainer($bootstrapConfigs);
    }

    private function buildContainer(BootstrapConfigs $bootstrapConfigs): ContainerBuilder
    {
        $configFiles = $this->createDefaultConfigFiles();
        $configFiles = array_merge($configFiles, $bootstrapConfigs->getAdditionalConfigFiles());
        $configFiles = array_merge($configFiles, $this->collectConfigFilesFromExtensions());

        $containerBuilderBuilder = new ContainerBuilderBuilder();
        return $containerBuilderBuilder->build($bootstrapConfigs->getMainConfigFile(), $configFiles);
    }

    /**
     * @return string[]
     */
    private function createDefaultConfigFiles(): array
    {
        return [__DIR__ . '/../../config/application.php'];
    }

    /**
     * @return string[]
     */
    private function collectConfigFilesFromExtensions(): array
    {
        $collectedConfigFiles = [];
        if (! class_exists('a9f\\FractorExtensionInstaller\\Generated\\InstalledPackages')) {
            return $collectedConfigFiles;
        }

        foreach (InstalledPackages::PACKAGES as $package) {
            $configPath = $package['path'] . '/config/application.php';

            if (! is_readable($configPath)) {
                throw new ShouldNotHappenException(sprintf(
                    'Config file "%s" is not readable or does not exist.',
                    $configPath
                ));
            }

            $collectedConfigFiles[] = $configPath;
        }

        return $collectedConfigFiles;
    }
}
