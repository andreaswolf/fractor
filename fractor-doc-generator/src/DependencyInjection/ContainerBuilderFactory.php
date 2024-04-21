<?php

namespace a9f\FractorDocGenerator\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Console\DependencyInjection\AddConsoleCommandPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

final class ContainerBuilderFactory
{
    public function createDependencyInjectionContainer(): ContainerInterface
    {
        $containerBuilder = new ContainerBuilder();

        $containerBuilder->addCompilerPass(new AddConsoleCommandPass());

        $configFiles = [
            __DIR__ . '/../../config/config.php'
        ];

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
}
