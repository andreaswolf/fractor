<?php

declare(strict_types=1);

namespace a9f\Fractor\DependencyInjection;

use a9f\Fractor\Configuration\FractorConfiguration;
use a9f\Fractor\Configuration\FractorConfigurationBuilder;
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
        $configurationBuilder = FractorConfiguration::configure();
        try {
            $containerBuilder->set(FractorConfigurationBuilder::class, $configurationBuilder);

            $containerBuilder->addCompilerPass(new AddConsoleCommandPass());

            $configFiles = [__DIR__ . '/../../config/application.php'];

            $fractorConfigFile ??= __DIR__ . '/../../config/fractor.php';

            $this->loadFractorConfigFile($fractorConfigFile, $containerBuilder, $configurationBuilder);

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
        } finally {
            // reset after we're done building the config
            FractorConfiguration::reset();
        }
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

    /**
     * The main fractor config file should return a callback that accepts any of the parameters that {@see PhpFileLoader}
     * can inject. This especially means that it can *NOT* accept the {@see FractorConfigurationBuilder} instance directly
     */
    private function loadFractorConfigFile(
        string $fractorConfigFile,
        ContainerBuilder $containerBuilder,
        FractorConfigurationBuilder $builder
    ): void {
        // ensure e.g. relative paths like "build/fractor.php" are correctly resolved by PhpFileLoader
        $absoluteFractorConfigFile = realpath($fractorConfigFile);
        if ($absoluteFractorConfigFile === false) {
            throw new \InvalidArgumentException(sprintf('File %s does not exist', $fractorConfigFile));
        }
        Assert::fileExists($absoluteFractorConfigFile);

        $loader = new PhpFileLoader($containerBuilder, new FileLocator(dirname($absoluteFractorConfigFile)));
        $loader->load($absoluteFractorConfigFile);

        $instanceOf = [];
        $builder(new ContainerConfigurator(
            $containerBuilder,
            $loader,
            $instanceOf,
            dirname($absoluteFractorConfigFile),
            basename($absoluteFractorConfigFile)
        ));
    }
}
