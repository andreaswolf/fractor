<?php

namespace a9f\Fractor\Application;

use a9f\Fractor\Application\Contract\FileProcessor;
use a9f\Fractor\Application\Contract\FileWriter;
use a9f\Fractor\Application\ValueObject\File;
use a9f\Fractor\Configuration\ValueObject\Configuration;
use a9f\Fractor\Console\Contract\Output;
use a9f\Fractor\Differ\ValueObjectFactory\FileDiffFactory;
use a9f\Fractor\FileSystem\FilesFinder;
use Nette\Utils\FileSystem;
use Webmozart\Assert\Assert;

/**
 * Main Fractor class. This takes care of collecting a list of files, iterating over them and calling all registered
 * processors for them.
 */
final readonly class FractorRunner
{
    /**
     * @param FileProcessor[] $processors
     */
    public function __construct(private FilesFinder $fileFinder, private FilesCollector $fileCollector, private iterable $processors, private FileWriter $fileWriter, private FileDiffFactory $fileDiffFactory)
    {
        Assert::allIsInstanceOf($this->processors, FileProcessor::class);
    }

    public function run(Output $output, Configuration $configuration): void
    {
        $filePaths = $this->fileFinder->findFiles($configuration->getPaths(), $configuration->getFileExtensions());

        $output->progressStart(count($filePaths));

        foreach ($filePaths as $filePath) {
            $file = new File($filePath, FileSystem::read($filePath));

            foreach ($this->processors as $processor) {
                if (!$processor->canHandle($file)) {
                    $output->progressAdvance();
                    continue;
                }

                $this->fileCollector->addFile($file);

                $processor->handle($file);
                $output->progressAdvance();
            }

            $file->setFileDiff($this->fileDiffFactory->createFileDiff($file));
        }

        $output->progressFinish();

        foreach ($this->fileCollector->getFiles() as $file) {
            if ($file->getFileDiff() === null) {
                continue;
            }

            $output->write($file->getFileDiff()->getDiffConsoleFormatted());

            if ($configuration->isDryRun()) {
                continue;
            }

            $this->fileWriter->write($file);
        }
    }
}
