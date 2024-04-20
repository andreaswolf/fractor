<?php

declare(strict_types=1);

namespace a9f\FractorDocGenerator\Tests;

use a9f\FractorDocGenerator\DependencyInjection\ContainerBuilderFactory;
use a9f\FractorDocGenerator\Exception\ShouldNotHappenException;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

abstract class AbstractTestCase extends TestCase
{
    private ?ContainerInterface $currentContainer = null;

    protected function setUp(): void
    {
        $this->boot();
    }

    protected function boot(): void
    {
        $this->currentContainer = (new ContainerBuilderFactory())->createDependencyInjectionContainer();
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
