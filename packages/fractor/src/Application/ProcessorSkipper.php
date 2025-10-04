<?php

declare(strict_types=1);

namespace a9f\Fractor\Application;

use a9f\Fractor\Application\Contract\FileProcessor;
use a9f\Fractor\Application\Contract\FractorRule;
use a9f\Fractor\Configuration\ValueObject\SkipConfiguration;

final readonly class ProcessorSkipper
{
    public function __construct(
        private SkipConfiguration $configuration
    ) {
    }

    /**
     * @param class-string<FileProcessor<FractorRule>> $processor
     */
    public function shouldSkip(string $processor): bool
    {
        $configuredSkip = $this->configuration->getSkip();

        // Check if the processor class is directly in the skip array
        return in_array($processor, $configuredSkip, true);
    }
}
