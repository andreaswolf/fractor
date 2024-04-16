<?php
declare(strict_types=1);

namespace a9f\Fractor\Testing\PHPUnit;

use a9f\Fractor\Configuration\FractorConfig;
use a9f\Fractor\DependencyInjection\ContainerBuilder;
use a9f\Fractor\Exception\ShouldNotHappenException;
use a9f\Fractor\Fractor\FractorRunner;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

abstract class AbstractFractorTestCase extends TestCase
{
    private static ?ContainerInterface $currentContainer = null;
    private FractorRunner $fractorRunner;

    abstract protected function provideConfigFilePath(): ?string;

    protected function additionalConfigurationFiles(): array
    {
        return [];
    }

    protected function setUp(): void
    {
        $this->bootFromConfigFile();
        $this->fractorRunner = $this->getService(FractorRunner::class);
    }

    protected function bootFromConfigFile(): void
    {
        if(self::$currentContainer === null) {
            self::$currentContainer = (new ContainerBuilder())->createDependencyInjectionContainer($this->provideConfigFilePath(), $this->additionalConfigurationFiles());
        }
    }

    protected function doTest(): void
    {
        $this->fractorRunner->run($this->getService(FractorConfig::class));
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
        if (self::$currentContainer === null) {
            throw new ShouldNotHappenException('First, create container with "bootWithConfigFileInfos([...])"');
        }

        $object = self::$currentContainer->get($type);
        if ($object === null) {
            $message = sprintf('Service "%s" was not found', $type);
            throw new ShouldNotHappenException($message);
        }

        return $object;
    }
}