<?php

namespace a9f\Fractor\DependencyInjection;

use a9f\Fractor\DependencyInjection\CompilerPass\CommandsCompilerPass;
use a9f\FractorExtensionInstaller\Generated\InstalledPackages;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

class ContainerContainerBuilder
{
    /**
     * @param array<int, string> $additionalConfigFiles
     */
    public function createDependencyInjectionContainer(array $additionalConfigFiles = []): ContainerInterface
    {
        $containerBuilder = new ContainerBuilder();
        $this->loadFile($containerBuilder, __DIR__ . '/../../config/application.php');
        $this->importExtensionConfigurations($containerBuilder);

        $containerBuilder->addCompilerPass(new CommandsCompilerPass());

        foreach ($additionalConfigFiles as $additionalConfigFile) {
            if (!file_exists($additionalConfigFile)) {
                continue;
            }
            $this->loadFile($containerBuilder, $additionalConfigFile);
        }

        $containerBuilder->compile();

        return $containerBuilder;
    }


    private function loadFile(ContainerBuilder $containerBuilder, string $pathToFile): void
    {
        $fileLoader = new PhpFileLoader($containerBuilder, new FileLocator(dirname($pathToFile)));
        $fileLoader->load($pathToFile);
    }

    private function importExtensionConfigurations(ContainerBuilder $containerBuilder): void
    {
        if (!class_exists('a9f\\FractorExtensionInstaller\\Generated\\InstalledPackages')) {
            return;
        }

        foreach (InstalledPackages::PACKAGES as $package) {
            $filePath = $package['path'] . '/config/application.php';

            if (file_exists($filePath)) {
                $this->loadFile($containerBuilder, $filePath);
            }
        }
    }
}
