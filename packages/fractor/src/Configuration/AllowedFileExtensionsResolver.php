<?php

declare(strict_types=1);

namespace a9f\Fractor\Configuration;

use a9f\Fractor\Application\Contract\FileProcessor;
use a9f\Fractor\Application\Contract\FractorRule;
use Webmozart\Assert\Assert;

final readonly class AllowedFileExtensionsResolver
{
    /**
     * @param iterable<FileProcessor<FractorRule>> $processors
     */
    public function __construct(
        private iterable $processors
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
            $fileExtensions = array_merge($processor->allowedFileExtensions(), $fileExtensions);
        }

        return array_unique($fileExtensions);
    }
}
