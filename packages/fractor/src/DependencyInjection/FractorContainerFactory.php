<?php

declare(strict_types=1);

namespace a9f\Fractor\DependencyInjection;

use a9f\Fractor\Caching\Detector\ChangedFilesDetector;
use a9f\Fractor\Kernel\FractorKernel;
use a9f\Fractor\ValueObject\Bootstrap\BootstrapConfigs;
use Psr\Container\ContainerInterface;

class FractorContainerFactory
{
    public function createDependencyInjectionContainer(BootstrapConfigs $bootstrapConfigs): ContainerInterface
    {
        $mainConfigFile = $bootstrapConfigs->getMainConfigFile();

        $container = $this->createFromConfigs($bootstrapConfigs);

        if ($mainConfigFile !== null) {
            /** @var ChangedFilesDetector $changedFilesDetector */
            $changedFilesDetector = $container->get(ChangedFilesDetector::class);
            $changedFilesDetector->setFirstResolvedConfigFileInfo($mainConfigFile);
        }

        return $container;
    }

    private function createFromConfigs(BootstrapConfigs $bootstrapConfigs): ContainerInterface
    {
        $fractorKernel = new FractorKernel();
        return $fractorKernel->createFromConfig($bootstrapConfigs);
    }
}
