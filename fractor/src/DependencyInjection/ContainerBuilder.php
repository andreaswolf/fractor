<?php

namespace a9f\Fractor\DependencyInjection;

use a9f\Fractor\DependencyInjection\CompilerPass\CommandsCompilerPass;
use a9f\Fractor\DependencyInjection\CompilerPass\FileProcessorCompilerPass;
use a9f\Fractor\Fractor\FileProcessor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerBuilder as SymfonyContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

class ContainerBuilder
{
    public function createDependencyInjectionContainer(): ContainerInterface
    {
        $containerBuilder = new SymfonyContainerBuilder();

        $yamlFileLoader = new PhpFileLoader($containerBuilder, new FileLocator(__DIR__ . '/../../config/'));
        $yamlFileLoader->load('application.php');

        $containerBuilder->registerForAutoconfiguration(FileProcessor::class)
            ->addTag('fractor.file_processor');

        $containerBuilder->set(Container::class, $containerBuilder);
        $containerBuilder->addCompilerPass(new CommandsCompilerPass());
        $containerBuilder->addCompilerPass(new FileProcessorCompilerPass());

        $containerBuilder->compile();

        return $containerBuilder;
    }
}