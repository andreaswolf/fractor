<?php

namespace a9f\Fractor\DependencyInjection;

use a9f\Fractor\Configuration\FractorConfig;
use a9f\Fractor\DependencyInjection\CompilerPass\CommandsCompilerPass;
use a9f\Fractor\DependencyInjection\CompilerPass\FileProcessorCompilerPass;
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
        $config->addCompilerPass(new FileProcessorCompilerPass());

        if ($fractorConfigFile !== null && is_file($fractorConfigFile)) {
            $config->import($fractorConfigFile);
        }

        foreach ($additionalConfigFiles as $additionalConfigFile) {
            $fileLoader = new PhpFileLoader($config, new FileLocator(dirname($additionalConfigFile)));
            $fileLoader->load($additionalConfigFile);
        }

        $this->registerConfiguredRules($config);
        $this->registerConfiguredFileProcessors($config);

        $config->compile();

        return $config;
    }

    private function registerConfiguredRules(FractorConfig $config): void
    {
        foreach ($config->getRules() as $rule) {
            $config->registerForAutoconfiguration($rule)
                ->addTag('fractor.rule');
        }
    }

    private function registerConfiguredFileProcessors(FractorConfig $config): void
    {
        foreach ($config->getFileProcessors() as $processor) {
            $config->registerForAutoconfiguration($processor)
                ->addTag('fractor.file_processor');
        }
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
