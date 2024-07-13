<?php

declare(strict_types=1);

namespace a9f\Fractor\Application;

use a9f\Fractor\Application\Contract\FileProcessor;
use a9f\Fractor\Application\Contract\FileWriter;
use a9f\Fractor\Application\Contract\FractorRule;
use a9f\Fractor\Application\ValueObject\File;
use a9f\Fractor\Configuration\ValueObject\Configuration;
use a9f\Fractor\Console\Contract\Output;
use a9f\Fractor\Differ\ValueObjectFactory\FileDiffFactory;
use a9f\Fractor\FileSystem\FilesFinder;
use a9f\Fractor\Reporting\FractorsChangelogLinesResolver;
use Nette\Utils\FileSystem;
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
        private FractorsChangelogLinesResolver $fractorsChangelogLinesResolver,
        private FilesFinder $fileFinder,
        private FilesCollector $fileCollector,
        private iterable $processors,
        private FileWriter $fileWriter,
        private FileDiffFactory $fileDiffFactory,
        private RuleSkipper $ruleSkipper
    ) {
        Assert::allIsInstanceOf($this->processors, FileProcessor::class);
    }

    public function run(Output $output, Configuration $configuration): void
    {
        $filePaths = $this->fileFinder->findFiles($configuration->getPaths(), $configuration->getFileExtensions());

        if (! $configuration->isQuiet()) {
            $output->progressStart(count($filePaths));
        }

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
        }

        if (! $configuration->isQuiet()) {
            $output->progressFinish();
        }

        foreach ($this->fileCollector->getFiles() as $file) {
            if ($file->getFileDiff() === null) {
                continue;
            }

            if (! $configuration->isQuiet()) {
                $output->write(sprintf('File: %s', $file->getFilePath()));
                $output->write('');

                $output->write($file->getFileDiff()->getDiffConsoleFormatted());
                if ($file->getAppliedRules() !== []) {
                    $fractorsChangelogsLines = $this->fractorsChangelogLinesResolver->createFractorChangelogLines(
                        $file->getAppliedRules()
                    );
                    $output->write('<options=underscore>Applied rules:</>');
                    $output->listing($fractorsChangelogsLines);
                    $output->newLine();
                }
            }

            if ($configuration->isDryRun()) {
                continue;
            }

            $this->fileWriter->write($file);
        }
    }

    /**
     * @param iterable<FractorRule> $rules
     * @return \Generator<FractorRule>
     */
    private function filterApplicableRules(iterable $rules, File $file): \Generator
    {
        foreach ($rules as $rule) {
            if ($this->ruleSkipper->shouldSkip($rule::class, $file->getFilePath())) {
                continue;
            }

            yield $rule;
        }
    }
}
