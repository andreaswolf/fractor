<?php

namespace a9f\Fractor\Fractor;

use a9f\Fractor\Contract\FilePrinter;
use a9f\Fractor\Contract\FileProcessor;
use a9f\Fractor\FileSystem\FileCollector;
use a9f\Fractor\FileSystem\FileFinder;
use a9f\Fractor\ValueObject\Configuration;
use a9f\Fractor\ValueObject\File;
use Nette\Utils\FileSystem;

/**
 * Main Fractor class. This takes care of collecting a list of files, iterating over them and calling all registered
 * processors for them.
 */
final readonly class FractorRunner
{
    /**
     * @param list<FileProcessor> $processors
     */
    public function __construct(private FileFinder $fileFinder, private FileCollector $fileCollector, private iterable $processors, private Configuration $configuration, private FilePrinter $filePrinter)
    {
    }

    public function run(bool $dryRun = false): void
    {
        if ($this->configuration->getPaths() === []) {
            throw new \RuntimeException('No directories given');
        }

        $files = $this->fileFinder->findFiles($this->configuration->getPaths(), $this->configuration->getFileExtensions());

        foreach ($files as $file) {
            foreach ($this->processors as $processor) {
                if (!$processor->canHandle($file)) {
                    continue;
                }

                $fractorFile = new File($file->getRealPath(), FileSystem::read($file->getRealPath()));
                $this->fileCollector->addFile($fractorFile);

                $processor->handle($fractorFile);
            }
        }


        foreach ($this->fileCollector->getFiles() as $file) {
            if ($dryRun) {
                continue;
            }

            $this->filePrinter->printFile($file);
        }
    }
}
