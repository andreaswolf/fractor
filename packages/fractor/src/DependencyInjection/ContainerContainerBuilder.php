<?php

declare(strict_types=1);

namespace a9f\Fractor\DependencyInjection;

use a9f\Fractor\Exception\ShouldNotHappenException;
use a9f\FractorExtensionInstaller\Generated\InstalledPackages;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Console\DependencyInjection\AddConsoleCommandPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Webmozart\Assert\Assert;

class ContainerContainerBuilder
{
    /**
     * @param string[] $additionalConfigFiles
     */
    public function createDependencyInjectionContainer(
        ?string $fractorConfigFile,
        array $additionalConfigFiles = []
    ): ContainerInterface {
        $containerBuilder = new ContainerBuilder();

        $containerBuilder->addCompilerPass(new AddConsoleCommandPass());

        $configFiles = [__DIR__ . '/../../config/application.php'];

        $fractorConfigFile ??= __DIR__ . '/../../config/fractor.php';

        $this->loadFractorConfigFile($fractorConfigFile, $containerBuilder);

        $configFiles = array_merge($configFiles, $additionalConfigFiles);
        $configFiles = array_merge($configFiles, $this->collectConfigFilesFromExtensions());

        foreach ($configFiles as $configFile) {
            if (! file_exists($configFile)) {
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
        if (! class_exists('a9f\\FractorExtensionInstaller\\Generated\\InstalledPackages')) {
            return $collectedConfigFiles;
        }

        foreach (InstalledPackages::PACKAGES as $package) {
            $configPath = $package['path'] . '/config/application.php';

            if (! is_readable($configPath)) {
                throw new ShouldNotHappenException(sprintf('Config file "%s" is not readable or does not exist.', $configPath));
            }

            $collectedConfigFiles[] = $configPath;
        }

        return $collectedConfigFiles;
    }

    private function loadFractorConfigFile(string $fractorConfigFile, ContainerBuilder $containerBuilder): void
    {
        Assert::fileExists($fractorConfigFile);

        $self = $this;
        $callable = (require $fractorConfigFile);

        Assert::isCallable($callable);
        $instanceOf = [];
        /** @var callable(ContainerConfigurator $container): void $callable */
        $callable(new ContainerConfigurator($containerBuilder, new PhpFileLoader($containerBuilder, new FileLocator(
            dirname($fractorConfigFile)
        )), $instanceOf, dirname($fractorConfigFile), basename($fractorConfigFile)));
    }
}
