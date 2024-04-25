<?php

declare(strict_types=1);

namespace a9f\Fractor\Testing\PHPUnit;

use a9f\Fractor\Application\FilesCollector;
use a9f\Fractor\Application\FractorRunner;
use a9f\Fractor\Configuration\ConfigurationFactory;
use a9f\Fractor\Console\Output\NullOutput;
use a9f\Fractor\DependencyInjection\ContainerContainerBuilder;
use a9f\Fractor\Exception\ShouldNotHappenException;
use a9f\Fractor\Testing\Contract\FractorTestInterface;
use a9f\Fractor\Testing\Fixture\FixtureFileFinder;
use a9f\Fractor\Testing\Fixture\FixtureSplitter;
use Nette\Utils\FileSystem;
use Nette\Utils\Strings;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

abstract class AbstractFractorTestCase extends TestCase implements FractorTestInterface
{
    private ?string $inputFilePath = null;
    private ?ContainerInterface $currentContainer = null;
    private FractorRunner $fractorRunner;
    protected FilesCollector $fileCollector;
    private ?string $copiedFile = null;

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
        $this->bootContainer();
        $this->fileCollector = $this->getService(FilesCollector::class);
        $this->fractorRunner = $this->getService(FractorRunner::class);
    }

    private function bootContainer(): void
    {
        $this->currentContainer = (new ContainerContainerBuilder())->createDependencyInjectionContainer($this->provideConfigFilePath(), $this->additionalConfigurationFiles());
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

    protected static function yieldFilesFromDirectory(string $directory, string $suffix): \Iterator
    {
        return FixtureFileFinder::yieldDirectory($directory, $suffix);
    }

    protected function doTestFile(string $fixtureFilePath): void
    {
        $this->copiedFile = $fixtureFilePath . '.tmp';

        FileSystem::copy($fixtureFilePath, $this->copiedFile);
        // prepare input file contents and expected file output contents
        $fixtureFileContents = FileSystem::read($fixtureFilePath);

        if (FixtureSplitter::containsSplit($fixtureFileContents)) {
            // changed content
            [$inputFileContents, $expectedFileContents] = FixtureSplitter::splitFixtureFileContents(
                $fixtureFileContents
            );
        } else {
            // no change
            $inputFileContents = $fixtureFileContents;
            $expectedFileContents = $fixtureFileContents;
        }

        $inputFilePath = $this->createInputFilePath($fixtureFilePath);
        // to remove later in tearDown()
        $this->inputFilePath = $inputFilePath;

        if ($fixtureFilePath === $this->copiedFile) {
            throw new ShouldNotHappenException('Fixture file and copied file cannot be the same: ' . $fixtureFilePath);
        }

        // write temp file
        FileSystem::write($inputFilePath, $inputFileContents, null);

        $this->doTestFileMatchesExpectedContent(
            $inputFilePath,
            $expectedFileContents,
            $fixtureFilePath
        );
    }

    private function doTestFileMatchesExpectedContent(
        string $originalFilePath,
        string $expectedFileContents,
        string $fixtureFilePath
    ): void {
        // the file is now changed (if any rule matches)
        $changedContents = $this->processFilePath($originalFilePath);

        $fixtureFilename = basename($fixtureFilePath);
        $failureMessage = sprintf('Failed on fixture file "%s"', $fixtureFilename);

        self::assertSame(trim($expectedFileContents), trim($changedContents), $failureMessage);
    }

    private function processFilePath(string $filePath): string
    {
        $configurationFactory = $this->getService(ConfigurationFactory::class);
        $configuration = $configurationFactory->createForTests([$filePath]);

        $this->fractorRunner->run(new NullOutput(), $configuration);

        // return changed file contents
        return FileSystem::read($filePath);
    }

    protected function tearDown(): void
    {
        // clear temporary file
        if (is_string($this->inputFilePath) && is_string($this->copiedFile)) {
            FileSystem::delete($this->inputFilePath);
            // restore copied file
            FileSystem::rename($this->copiedFile, $this->inputFilePath);
        }
    }

    private function createInputFilePath(string $fixtureFilePath): string
    {
        $inputFileDirectory = dirname($fixtureFilePath);

        // remove ".inc" suffix
        if (str_ends_with($fixtureFilePath, '.inc')) {
            $trimmedFixtureFilePath = Strings::substring($fixtureFilePath, 0, -4);
        } else {
            $trimmedFixtureFilePath = $fixtureFilePath;
        }

        $fixtureBasename = pathinfo($trimmedFixtureFilePath, PATHINFO_BASENAME);
        return $inputFileDirectory . '/' . $fixtureBasename;
    }
}
