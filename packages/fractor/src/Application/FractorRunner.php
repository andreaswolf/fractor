<?php

declare(strict_types=1);

namespace a9f\Fractor\Application;

use a9f\Fractor\Application\Contract\FileProcessor;
use a9f\Fractor\Application\Contract\FileWriter;
use a9f\Fractor\Application\Contract\FractorRule;
use a9f\Fractor\Application\ValueObject\File;
use a9f\Fractor\Caching\Detector\ChangedFilesDetector;
use a9f\Fractor\Configuration\ConfigurationRuleFilter;
use a9f\Fractor\Configuration\ValueObject\Configuration;
use a9f\Fractor\Differ\ValueObject\FileDiff;
use a9f\Fractor\Differ\ValueObjectFactory\FileDiffFactory;
use a9f\Fractor\FileSystem\FilesFinder;
use a9f\Fractor\ValueObject\FileProcessResult;
use a9f\Fractor\ValueObject\ProcessResult;
use Nette\Utils\FileSystem;
use Symfony\Component\Console\Style\SymfonyStyle;
use Webmozart\Assert\Assert;

/**
 * Main Fractor class. This takes care of collecting a list of files, iterating over them and calling all registered
 * processors for them.
 */
final readonly class FractorRunner
{
    /**
     * @param iterable<FileProcessor<FractorRule>> $processors
     */
    public function __construct(
        private SymfonyStyle $symfonyStyle,
        private FilesFinder $fileFinder,
        private FilesCollector $fileCollector,
        private iterable $processors,
        private FileWriter $fileWriter,
        private FileDiffFactory $fileDiffFactory,
        private RuleSkipper $ruleSkipper,
        private ProcessorSkipper $processorSkipper,
        private ChangedFilesDetector $changedFilesDetector,
        private ConfigurationRuleFilter $configurationRuleFilter
    ) {
        Assert::allIsInstanceOf($this->processors, FileProcessor::class);
    }

    public function run(Configuration $configuration): ProcessResult
    {
        $filePaths = $this->fileFinder->findFiles($configuration->getPaths(), $configuration->getFileExtensions());

        // no files found
        if ($filePaths === []) {
            return new ProcessResult([]);
        }

        $shouldShowProgressBar = $configuration->shouldShowProgressBar();

        if ($shouldShowProgressBar && ! $configuration->isQuiet()) {
            $this->symfonyStyle->progressStart(count($filePaths));
            $this->symfonyStyle->progressAdvance(0);
        }

        /** @var FileDiff[] $fileDiffs */
        $fileDiffs = [];

        foreach ($filePaths as $filePath) {
            $file = new File($filePath, FileSystem::read($filePath));
            $this->fileCollector->addFile($file);

            if ($shouldShowProgressBar && ! $configuration->isQuiet()) {
                $this->symfonyStyle->progressAdvance();
            }
            foreach ($this->processors as $processor) {
                if ($this->processorSkipper->shouldSkip($processor::class)) {
                    continue;
                }

                if (! $processor->canHandle($file)) {
                    continue;
                }

                $applicableRules = $this->filterApplicableRules($processor->getAllRules(), $file);

                $processor->handle($file, $applicableRules);
            }

            if (! $file->hasChanged()) {
                $this->changedFilesDetector->cacheFile($file->getFilePath());
                continue;
            }

            $file->setFileDiff($this->fileDiffFactory->createFileDiff($file));

            $fileProcessResult = new FileProcessResult($file->getFileDiff());
            $currentFileDiff = $fileProcessResult->getFileDiff();
            if ($currentFileDiff instanceof FileDiff) {
                $fileDiffs[] = $currentFileDiff;
            }
        }

        foreach ($this->fileCollector->getFiles() as $file) {
            if ($file->getFileDiff() === null) {
                continue;
            }

            if ($configuration->isDryRun()) {
                continue;
            }

            $this->fileWriter->write($file);
        }

        return new ProcessResult($fileDiffs);
    }

    /**
     * @param iterable<FractorRule> $rules
     * @return \Generator<FractorRule>
     */
    private function filterApplicableRules(iterable $rules, File $file): \Generator
    {
        $rules = $this->configurationRuleFilter->filter($rules);

        foreach ($rules as $rule) {
            if ($this->ruleSkipper->shouldSkip($rule::class, $file->getFilePath())) {
                continue;
            }

            yield $rule;
        }
    }
}
