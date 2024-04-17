<?php

namespace a9f\Fractor\DependencyInjection;

use a9f\Fractor\DependencyInjection\CompilerPass\CommandsCompilerPass;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

class ContainerContainerBuilder
{
    /**
     * @param array<int, string> $additionalConfigFiles
     */
    public function createDependencyInjectionContainer(array $additionalConfigFiles = []): ContainerInterface
    {
        $config = new \Symfony\Component\DependencyInjection\ContainerBuilder();
        $fileLoader = new PhpFileLoader($config, new FileLocator(__DIR__ . '/../../config/'));
        $fileLoader->load('application.php');

        $this->importExtensionConfigurations($config);

        $config->addCompilerPass(new CommandsCompilerPass());

        foreach ($additionalConfigFiles as $additionalConfigFile) {
            $fileLoader = new PhpFileLoader($config, new FileLocator(dirname($additionalConfigFile)));
            $fileLoader->load($additionalConfigFile);
        }

        $config->compile();

        return $config;
    }

    private function importExtensionConfigurations(\Symfony\Component\DependencyInjection\ContainerBuilder $config): void
    {
        if (!class_exists('a9f\\FractorExtensionInstaller\\Generated\\InstalledPackages')) {
            return;
        }

        foreach (\a9f\FractorExtensionInstaller\Generated\InstalledPackages::PACKAGES as $package) {
            $extensionBasePath = $package['path'];
            $filePath = $extensionBasePath . '/config/application.php';

            if (file_exists($filePath)) {
                $fileLoader = new PhpFileLoader($config, new FileLocator(dirname($filePath)));
                $fileLoader->load(basename($filePath));
            }
        }
    }
}
