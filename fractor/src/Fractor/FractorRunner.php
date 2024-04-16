<?php

namespace a9f\Fractor\Fractor;

use a9f\Fractor\Configuration\FractorConfig;
use a9f\Fractor\Contract\FileProcessor;
use a9f\Fractor\FileSystem\FileFinder;

/**
 * Main Fractor class. This takes care of collecting a list of files, iterating over them and calling all registered
 * processors for them.
 */
final class FractorRunner
{
    /**
     * @param list<FileProcessor> $processors
     */
    public function __construct(private readonly FileFinder $fileFinder, private readonly array $processors)
    {
    }

    public function run(FractorConfig $config): void
    {
        if ($config->getPaths() === []) {
            throw new \RuntimeException('No directories given');
        }
        $files = $this->fileFinder->findFiles($config->getPaths(), $config->getFileExtensions());

        foreach ($files as $file) {
            foreach ($this->processors as $processor) {
                if (!$processor->canHandle($file)) {
                    continue;
                }

                $processor->handle($file);
            }
        }
    }
}
