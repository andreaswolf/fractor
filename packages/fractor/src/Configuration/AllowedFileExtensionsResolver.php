<?php

declare(strict_types=1);

namespace a9f\Fractor\Configuration;

use a9f\Fractor\Application\Contract\FileProcessor;
use a9f\Fractor\Application\Contract\FractorRule;
use Webmozart\Assert\Assert;

final class AllowedFileExtensionsResolver
{
    /**
     * @var iterable<FileProcessor<FractorRule>>
     * @readonly
     */
    private iterable $processors;

    /**
     * @param iterable<FileProcessor<FractorRule>> $processors
     */
    public function __construct(
        iterable $processors
    ) {
        $this->processors = $processors;
        Assert::allIsInstanceOf($this->processors, FileProcessor::class);
    }

    /**
     * @return list<non-empty-string>
     */
    public function resolve(): array
    {
        $fileExtensions = [];
        foreach ($this->processors as $processor) {
            $fileExtensions = array_merge($processor->allowedFileExtensions(), $fileExtensions);
        }

        return array_unique($fileExtensions);
    }
}
