<?php

namespace a9f\Fractor\DependencyInjection;

use a9f\FractorExtensionInstaller\Generated\InstalledPackages;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Console\DependencyInjection\AddConsoleCommandPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

class ContainerContainerBuilder
{
    /**
     * @param string[] $additionalConfigFiles
     */
    public function createDependencyInjectionContainer(array $additionalConfigFiles = []): ContainerInterface
    {
        $containerBuilder = new ContainerBuilder();

        $containerBuilder->addCompilerPass(new AddConsoleCommandPass());

        $configFiles = [
            __DIR__ . '/../../config/application.php'
        ];
        $configFiles = array_merge($configFiles, $additionalConfigFiles);
        $configFiles = array_merge($configFiles, $this->collectConfigFilesFromExtensions());

        foreach ($configFiles as $configFile) {
            if (!file_exists($configFile)) {
                continue;
            }

            $fileLoader = new PhpFileLoader($containerBuilder, new FileLocator(dirname($configFile)));
            $fileLoader->load($configFile);
        }

        $containerBuilder->compile();

        return $containerBuilder;
    }

    /**
     * @return string[]
     */
    private function collectConfigFilesFromExtensions(): array
    {
        $collectedConfigFiles = [];
        if (!class_exists('a9f\\FractorExtensionInstaller\\Generated\\InstalledPackages')) {
            return $collectedConfigFiles;
        }

        foreach (InstalledPackages::PACKAGES as $package) {
            $collectedConfigFiles[] = $package['path'] . '/config/application.php';
        }

        return $collectedConfigFiles;
    }
}
