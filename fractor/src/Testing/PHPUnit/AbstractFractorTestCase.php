<?php

declare(strict_types=1);

namespace a9f\Fractor\Testing\PHPUnit;

use a9f\Fractor\Application\FilesCollector;
use a9f\Fractor\Application\FractorRunner;
use a9f\Fractor\Console\Output\NullOutput;
use a9f\Fractor\DependencyInjection\ContainerContainerBuilder;
use a9f\Fractor\Exception\ShouldNotHappenException;
use a9f\Fractor\Testing\Contract\FractorTestInterface;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

abstract class AbstractFractorTestCase extends TestCase implements FractorTestInterface
{
    private ?ContainerInterface $currentContainer = null;
    private FractorRunner $fractorRunner;
    protected FilesCollector $fileCollector;

    /**
     * @return array<int, string>
     */
    protected function additionalConfigurationFiles(): array
    {
        return [];
    }

    public function provideConfigFilePath(): ?string
    {
        return null;
    }

    protected function setUp(): void
    {
        $this->bootFromConfigFile();
        $this->fileCollector = $this->getService(FilesCollector::class);
        $this->fractorRunner = $this->getService(FractorRunner::class);
    }

    protected function bootFromConfigFile(): void
    {
        $this->currentContainer = (new ContainerContainerBuilder())->createDependencyInjectionContainer($this->provideConfigFilePath(), $this->additionalConfigurationFiles());
    }

    protected function doTest(): void
    {
        $this->fractorRunner->run(new NullOutput(), true);

        foreach ($this->fileCollector->getFiles() as $file) {
            $assertionFile = $file->getDirectoryName() . '/../Assertions/' . $file->getFileName();

            if (file_exists($assertionFile)) {
                self::assertStringEqualsFile($assertionFile, $file->getContent());
            } else {
                self::assertFalse($file->hasChanged());
            }
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
