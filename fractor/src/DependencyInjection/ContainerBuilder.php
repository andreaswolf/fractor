<?php

namespace a9f\Fractor\DependencyInjection;

use a9f\Fractor\Configuration\FractorConfig;
use a9f\Fractor\DependencyInjection\CompilerPass\CommandsCompilerPass;
use a9f\Fractor\DependencyInjection\CompilerPass\FileProcessorCompilerPass;
use a9f\Fractor\Fractor\FileProcessor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

class ContainerBuilder
{
    public function createDependencyInjectionContainer(?string $fractorConfigFile): ContainerInterface
    {
        $config = new FractorConfig();

        $definition = new Definition(FractorConfig::class);
        $definition->setPublic(true);
        $config->set(Container::class, $config);
        $config->set(FractorConfig::class, $config);

        $yamlFileLoader = new PhpFileLoader($config, new FileLocator(__DIR__ . '/../../config/'));
        $yamlFileLoader->load('application.php');

        $config->registerForAutoconfiguration(FileProcessor::class)
            ->addTag('fractor.file_processor');

        $config->addCompilerPass(new CommandsCompilerPass());
        $config->addCompilerPass(new FileProcessorCompilerPass());

        $config->compile();

        if (is_file($fractorConfigFile)) {
            $config->import($fractorConfigFile);
        }

        return $config;
    }
}