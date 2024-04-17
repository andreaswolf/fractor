<?php

declare(strict_types=1);

namespace a9f\Fractor\Testing\PHPUnit;

use a9f\Fractor\DependencyInjection\ContainerContainerBuilder;
use a9f\Fractor\Exception\ShouldNotHappenException;
use a9f\Fractor\FileSystem\FileCollector;
use a9f\Fractor\Fractor\FractorRunner;
use a9f\Fractor\ValueObject\Configuration;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

abstract class AbstractFractorTestCase extends TestCase
{
    private ?ContainerInterface $currentContainer = null;
    private FractorRunner $fractorRunner;
    protected FileCollector $fileCollector;
    private Configuration $configuration;

    /**
     * @return array<int, string>
     */
    protected function additionalConfigurationFiles(): array
    {
        return [];
    }

    protected function setUp(): void
    {
        $this->bootFromConfigFile();
        $this->fileCollector = $this->getService(FileCollector::class);
        $this->fractorRunner = $this->getService(FractorRunner::class);
    }

    protected function bootFromConfigFile(): void
    {
        $this->currentContainer = (new ContainerContainerBuilder())->createDependencyInjectionContainer($this->additionalConfigurationFiles());
    }

    protected function doTest(): void
    {
        $this->fractorRunner->run(true);
    }

    /**
     * Syntax-sugar to remove static
     *
     * @template T of object
     * @phpstan-param class-string<T> $type
     * @phpstan-return T
     */
    protected function getService(string $type): object
    {
        if ($this->currentContainer === null) {
            throw new ShouldNotHappenException('First, create container with "bootWithConfigFileInfos([...])"');
        }

        $object = $this->currentContainer->get($type);
        if ($object === null) {
            $message = sprintf('Service "%s" was not found', $type);
            throw new ShouldNotHappenException($message);
        }

        return $object;
    }
}
