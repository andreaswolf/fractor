<?php

namespace a9f\Fractor\Application;

use a9f\Fractor\Application\Contract\FilePrinter;
use a9f\Fractor\Application\Contract\FileProcessor;
use a9f\Fractor\Application\ValueObject\File;
use a9f\Fractor\Configuration\ValueObject\Configuration;
use a9f\Fractor\Console\Contract\Output;
use a9f\Fractor\FileSystem\FilesFinder;
use Nette\Utils\FileSystem;

/**
 * Main Fractor class. This takes care of collecting a list of files, iterating over them and calling all registered
 * processors for them.
 */
final readonly class FractorRunner
{
    /**
     * @param FileProcessor[] $processors
     */
    public function __construct(private FilesFinder $fileFinder, private FilesCollector $fileCollector, private iterable $processors, private Configuration $configuration, private FilePrinter $filePrinter)
    {
    }

    public function run(Output $output, bool $dryRun = false): void
    {
        $filePaths = $this->fileFinder->findFiles($this->configuration->getPaths(), $this->configuration->getFileExtensions());

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
        }


        if (!$dryRun) {
            foreach ($this->fileCollector->getFiles() as $file) {
                $this->filePrinter->printFile($file);
            }
        }

        $output->progressFinish();
    }
}
