<?php

declare(strict_types=1);

namespace a9f\Fractor\Configuration;

use a9f\Fractor\ChangesReporting\Output\ConsoleOutputFormatter;
use a9f\Fractor\Configuration\Parameter\SimpleParameterProvider;
use a9f\Fractor\Configuration\ValueObject\Configuration;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Webmozart\Assert\Assert;

final readonly class ConfigurationFactory
{
    public function __construct(
        private AllowedFileExtensionsResolver $allowedFileExtensionsResolver,
        private OnlyRuleResolver $onlyRuleResolver,
        private SymfonyStyle $symfonyStyle
    ) {
    }

    public function createFromInput(InputInterface $input): Configuration
    {
        $dryRun = (bool) $input->getOption(Option::DRY_RUN);

        $outputFormat = (string) $input->getOption(Option::OUTPUT_FORMAT);
        $showProgressBar = $this->shouldShowProgressBar($input, $outputFormat);
        $showDiffs = $this->shouldShowDiffs($input);
        $showChangelog = $this->shouldShowChangelog($input);

        /** @var list<non-empty-string> $paths */
        $paths = $this->resolvePaths($input);

        $fileExtensions = $this->allowedFileExtensionsResolver->resolve();

        // filter rule and path
        $onlyRule = $input->getOption(Option::ONLY);
        if ($onlyRule !== null) {
            $onlyRule = $this->onlyRuleResolver->resolve($onlyRule);
        }

        $memoryLimit = $this->resolveMemoryLimit($input);

        return new Configuration(
            $dryRun,
            $showProgressBar,
            $outputFormat,
            $fileExtensions,
            $paths,
            $showDiffs,
            $memoryLimit,
            $onlyRule,
            $showChangelog
        );
    }

    /**
     * @api used in tests
     * @param list<non-empty-string> $paths
     */
    public function createForTests(array $paths): Configuration
    {
        Assert::allStringNotEmpty($paths, 'No directories given');

        $fileExtensions = $this->allowedFileExtensionsResolver->resolve();

        return new Configuration(false, true, ConsoleOutputFormatter::NAME, $fileExtensions, $paths);
    }

    private function shouldShowProgressBar(InputInterface $input, string $outputFormat): bool
    {
        $noProgressBar = (bool) $input->getOption(Option::NO_PROGRESS_BAR);
        if ($noProgressBar) {
            return false;
        }

        if ($this->symfonyStyle->isVerbose()) {
            return false;
        }

        return $outputFormat === ConsoleOutputFormatter::NAME;
    }

    private function shouldShowDiffs(InputInterface $input): bool
    {
        $noDiffs = (bool) $input->getOption(Option::NO_DIFFS);
        if ($noDiffs) {
            return false;
        }

        // fallback to parameter
        return ! SimpleParameterProvider::provideBoolParameter(Option::NO_DIFFS, false);
    }

    private function shouldShowChangelog(InputInterface $input): bool
    {
        return (bool) $input->getOption(Option::SHOW_CHANGELOG);
    }

    /**
     * @return string[]|mixed[]
     */
    private function resolvePaths(InputInterface $input): array
    {
        $commandLinePaths = (array) $input->getArgument(Option::SOURCE);

        // give priority to command line
        if ($commandLinePaths !== []) {
            $this->setFilesWithoutExtensionParameter($commandLinePaths);
            return $commandLinePaths;
        }

        // fallback to parameter
        $configPaths = SimpleParameterProvider::provideArrayParameter(Option::PATHS);
        $this->setFilesWithoutExtensionParameter($configPaths);

        return $configPaths;
    }

    /**
     * @param string[] $paths
     */
    private function setFilesWithoutExtensionParameter(array $paths): void
    {
        foreach ($paths as $path) {
            if (is_file($path) && pathinfo($path, PATHINFO_EXTENSION) === '') {
                $path = realpath($path);

                if ($path === false) {
                    continue;
                }

                SimpleParameterProvider::addParameter(Option::FILES_WITHOUT_EXTENSION, $path);
            }
        }
    }

    private function resolveMemoryLimit(InputInterface $input): string | null
    {
        $memoryLimit = $input->getOption(Option::MEMORY_LIMIT);
        if ($memoryLimit !== null) {
            return (string) $memoryLimit;
        }

        if (! SimpleParameterProvider::hasParameter(Option::MEMORY_LIMIT)) {
            return null;
        }

        return SimpleParameterProvider::provideStringParameter(Option::MEMORY_LIMIT);
    }
}
