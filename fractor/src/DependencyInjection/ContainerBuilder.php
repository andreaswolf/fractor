<?php

namespace a9f\Fractor\DependencyInjection;

use a9f\Fractor\Configuration\FractorConfig;
use a9f\Fractor\DependencyInjection\CompilerPass\CommandsCompilerPass;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

class ContainerBuilder
{
    public function createDependencyInjectionContainer(?string $fractorConfigFile, array $additionalConfigFiles = []): ContainerInterface
    {
        $config = new FractorConfig();

        $definition = new Definition(FractorConfig::class);
        $definition->setPublic(true);
        $config->set(Container::class, $config);
        $config->set(FractorConfig::class, $config);

        $fileLoader = new PhpFileLoader($config, new FileLocator(__DIR__ . '/../../config/'));
        $fileLoader->load('application.php');

        $this->importExtensionConfigurations($config);

        $config->addCompilerPass(new CommandsCompilerPass());

        if ($fractorConfigFile !== null && is_file($fractorConfigFile)) {
            $config->import($fractorConfigFile);
        }

        foreach ($additionalConfigFiles as $additionalConfigFile) {
            $fileLoader = new PhpFileLoader($config, new FileLocator(dirname($additionalConfigFile)));
            $fileLoader->load($additionalConfigFile);
        }

        $config->compile();

        return $config;
    }

    private function importExtensionConfigurations(FractorConfig $config): void
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
