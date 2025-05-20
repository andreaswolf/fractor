<?php

declare(strict_types=1);

namespace a9f\Fractor\Testing\PHPUnit;

use a9f\Fractor\Application\Contract\FractorRule;
use a9f\Fractor\Application\FilesCollector;
use a9f\Fractor\Application\FractorRunner;
use a9f\Fractor\Application\ValueObject\AppliedRule;
use a9f\Fractor\Application\ValueObject\File;
use a9f\Fractor\Configuration\ConfigurationFactory;
use a9f\Fractor\Console\Output\NullOutput;
use a9f\Fractor\DependencyInjection\ContainerContainerBuilder;
use a9f\Fractor\Exception\ShouldNotHappenException;
use a9f\Fractor\Testing\Contract\FractorTestInterface;
use a9f\Fractor\Testing\Fixture\FixtureFileFinder;
use a9f\Fractor\Testing\Fixture\FixtureSplitter;
use a9f\Fractor\Testing\PHPUnit\ValueObject\FractorTestResult;
use Nette\Utils\FileSystem;
use Nette\Utils\Strings;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

abstract class AbstractFractorTestCase extends TestCase implements FractorTestInterface
{
    protected FilesCollector $fileCollector;

    private ?string $inputFilePath = null;

    private ?ContainerInterface $currentContainer = null;

    private FractorRunner $fractorRunner;

    protected function setUp(): void
    {
        $this->bootContainer();
        $this->fileCollector = $this->getService(FilesCollector::class);
        $this->fractorRunner = $this->getService(FractorRunner::class);
    }

    protected function tearDown(): void
    {
        // clear temporary file
        if (\is_string($this->inputFilePath)) {
            FileSystem::delete($this->inputFilePath);
        }

        unset($this->currentContainer);
    }

    public function provideConfigFilePath(): ?string
    {
        return null;
    }

    /**
     * @return array<int, string>
     */
    protected function additionalConfigurationFiles(): array
    {
        return [];
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
        if ($fixtureFilePath === $inputFilePath) {
            throw new ShouldNotHappenException('Fixture file and input file cannot be the same: ' . $fixtureFilePath);
        }

        // write temp file
        FileSystem::write($inputFilePath, $inputFileContents, null);

        $this->doTestFileMatchesExpectedContent($inputFilePath, $expectedFileContents, $fixtureFilePath);
    }

    /**
     * @param class-string<FractorRule> $rule
     */
    protected function assertThatRuleIsApplied(string $rule): void
    {
        if (! \is_string($this->inputFilePath)) {
            self::fail('inputFilePath is not a string');
        }
        $file = $this->fileCollector->getFileByPath($this->inputFilePath);
        self::assertInstanceOf(File::class, $file);
        self::assertEquals([AppliedRule::fromClassString($rule)], $file->getAppliedRules());
    }

    private function bootContainer(): void
    {
        $this->currentContainer = (new ContainerContainerBuilder())->createDependencyInjectionContainer(
            $this->provideConfigFilePath(),
            $this->additionalConfigurationFiles()
        );
    }

    /**
     * @param non-empty-string $originalFilePath
     */
    private function doTestFileMatchesExpectedContent(
        string $originalFilePath,
        string $expectedFileContents,
        string $fixtureFilePath
    ): void {
        // the file is now changed (if any rule matches)
        $fractorTestResult = $this->processFilePath($originalFilePath);
        $changedContents = $fractorTestResult->getChangedContents();

        $fixtureFilename = basename($fixtureFilePath);
        $failureMessage = sprintf('Failed on fixture file "%s"', $fixtureFilename);
        // give more context about used rules in case of set testing
        if (\count($fractorTestResult->getAppliedFractorRules()) > 0) {
            $failureMessage .= \PHP_EOL . \PHP_EOL;
            $failureMessage .= 'Applied Fractor rules:' . \PHP_EOL;
            foreach ($fractorTestResult->getAppliedFractorRules() as $appliedFractorRule) {
                $failureMessage .= ' * ' . $appliedFractorRule . \PHP_EOL;
            }
        }

        self::assertSame(trim($expectedFileContents), trim($changedContents), $failureMessage);
    }

    /**
     * @param non-empty-string $filePath
     */
    private function processFilePath(string $filePath): FractorTestResult
    {
        $configurationFactory = $this->getService(ConfigurationFactory::class);
        $configuration = $configurationFactory->createForTests([$filePath]);

        $processResult = $this->fractorRunner->run(new NullOutput(), $configuration);

        // return changed file contents
        $changedFileContents = FileSystem::read($filePath);

        return new FractorTestResult($changedFileContents, $processResult);
    }

    /**
     * @return non-empty-string
     */
    private function createInputFilePath(string $fixtureFilePath): string
    {
        $inputFileDirectory = \dirname($fixtureFilePath);
        // remove ".fixture" suffix
        if (str_ends_with($fixtureFilePath, '.fixture')) {
            $trimmedFixtureFilePath = Strings::substring($fixtureFilePath, 0, -8);
        } else {
            $trimmedFixtureFilePath = $fixtureFilePath;
        }
        $fixtureBasename = \pathinfo($trimmedFixtureFilePath, \PATHINFO_BASENAME);
        return $inputFileDirectory . '/' . $fixtureBasename;
    }
}
