<?php

declare(strict_types=1);

namespace a9f\Fractor\Application;

use a9f\Fractor\Application\Contract\FileProcessor;
use a9f\Fractor\Application\Contract\FileWriter;
use a9f\Fractor\Application\Contract\FractorRule;
use a9f\Fractor\Application\ValueObject\File;
use a9f\Fractor\Configuration\ValueObject\Configuration;
use a9f\Fractor\Console\Contract\Output;
use a9f\Fractor\Differ\ValueObject\FileDiff;
use a9f\Fractor\Differ\ValueObjectFactory\FileDiffFactory;
use a9f\Fractor\FileSystem\FilesFinder;
use a9f\Fractor\ValueObject\FileProcessResult;
use a9f\Fractor\ValueObject\ProcessResult;
use Nette\Utils\FileSystem;
use Webmozart\Assert\Assert;

/**
 * Main Fractor class. This takes care of collecting a list of files, iterating over them and calling all registered
 * processors for them.
 */
final class FractorRunner
{
    /**
     * @readonly
     */
    private FilesFinder $fileFinder;

    /**
     * @readonly
     */
    private FilesCollector $fileCollector;

    /**
     * @var iterable<FileProcessor<FractorRule>>
     * @readonly
     */
    private iterable $processors;

    /**
     * @readonly
     */
    private FileWriter $fileWriter;

    /**
     * @readonly
     */
    private FileDiffFactory $fileDiffFactory;

    /**
     * @readonly
     */
    private RuleSkipper $ruleSkipper;

    /**
     * @param iterable<FileProcessor<FractorRule>> $processors
     */
    public function __construct(
        FilesFinder $fileFinder,
        FilesCollector $fileCollector,
        iterable $processors,
        FileWriter $fileWriter,
        FileDiffFactory $fileDiffFactory,
        RuleSkipper $ruleSkipper
    ) {
        $this->fileFinder = $fileFinder;
        $this->fileCollector = $fileCollector;
        $this->processors = $processors;
        $this->fileWriter = $fileWriter;
        $this->fileDiffFactory = $fileDiffFactory;
        $this->ruleSkipper = $ruleSkipper;
        Assert::allIsInstanceOf($this->processors, FileProcessor::class);
    }

    public function run(Output $output, Configuration $configuration): ProcessResult
    {
        $filePaths = $this->fileFinder->findFiles($configuration->getPaths(), $configuration->getFileExtensions());

        if (! $configuration->isQuiet()) {
            $output->progressStart(count($filePaths));
        }

        /** @var FileDiff[] $fileDiffs */
        $fileDiffs = [];

        foreach ($filePaths as $filePath) {
            $file = new File($filePath, FileSystem::read($filePath));
            $this->fileCollector->addFile($file);

            if (! $configuration->isQuiet()) {
                $output->progressAdvance();
            }
            foreach ($this->processors as $processor) {
                if (! $processor->canHandle($file)) {
                    continue;
                }

                $applicableRules = $this->filterApplicableRules($processor->getAllRules(), $file);

                $processor->handle($file, $applicableRules);
            }

            if (! $file->hasChanged()) {
                continue;
            }

            $file->setFileDiff($this->fileDiffFactory->createFileDiff($file));

            $fileProcessResult = new FileProcessResult($file->getFileDiff());
            $currentFileDiff = $fileProcessResult->getFileDiff();
            if ($currentFileDiff instanceof FileDiff) {
                $fileDiffs[] = $currentFileDiff;
            }
        }

        if (! $configuration->isQuiet()) {
            $output->progressFinish();
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
        foreach ($rules as $rule) {
            if ($this->ruleSkipper->shouldSkip(get_class($rule), $file->getFilePath())) {
                continue;
            }

            yield $rule;
        }
    }
}
