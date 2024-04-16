<?php
declare(strict_types=1);

namespace a9f\Fractor\Testing\PHPUnit;

use a9f\Fractor\DependencyInjection\ContainerBuilder;
use a9f\Fractor\Exception\ShouldNotHappenException;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

abstract class AbstractFractorTestCase extends TestCase
{
    private static ?ContainerInterface $currentContainer = null;
    abstract protected function provideConfigFilePath(): string;

    protected function setUp(): void
    {
        $this->bootFromConfigFile($this->provideConfigFilePath());
    }

    protected function bootFromConfigFile(string $configFile): void
    {
        if(self::$currentContainer === null) {
            self::$currentContainer = (new ContainerBuilder())->createDependencyInjectionContainer($configFile);
        }
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