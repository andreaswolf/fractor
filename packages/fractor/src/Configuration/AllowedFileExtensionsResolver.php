<?php

declare(strict_types=1);

namespace a9f\Fractor\Configuration;

use a9f\Fractor\Application\Contract\FileProcessor;
use a9f\Fractor\Application\Contract\FractorRule;
use a9f\Fractor\Application\ProcessorSkipper;
use Webmozart\Assert\Assert;

final readonly class AllowedFileExtensionsResolver
{
    /**
     * @param iterable<FileProcessor<FractorRule>> $processors
     */
    public function __construct(
        private iterable $processors,
        private ProcessorSkipper $processorSkipper
    ) {
        Assert::allIsInstanceOf($this->processors, FileProcessor::class);
    }

    /**
     * @return array<int<0, max>, non-empty-string>
     */
    public function resolve(): array
    {
        $fileExtensions = [];
        foreach ($this->processors as $processor) {
            if ($this->processorSkipper->shouldSkip($processor::class)) {
                continue;
            }

            $fileExtensions = array_merge($processor->allowedFileExtensions(), $fileExtensions);
        }

        return array_unique($fileExtensions);
    }
}
