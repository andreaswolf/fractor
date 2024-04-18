<?php

declare(strict_types=1);

namespace a9f\Fractor\Skipper\SkipCriteriaResolver;

use a9f\Fractor\Configuration\ValueObject\Configuration;
use a9f\Fractor\Skipper\FileSystem\FilePathHelper;

final class SkippedPathsResolver
{
    /**
     * @var null|string[]
     */
    private null|array $skippedPaths = null;

    public function __construct(
        private readonly FilePathHelper $filePathHelper,
        private readonly Configuration $configuration
    ) {
    }

    /**
     * @return string[]
     */
    public function resolve(): array
    {
        // already cached, even only empty array
        if ($this->skippedPaths !== null) {
            return $this->skippedPaths;
        }

        $skip = $this->configuration->getSkip();
        $this->skippedPaths = [];

        foreach ($skip as $key => $value) {
            if (!is_int($key)) {
                continue;
            }

            if (\str_contains($value, '*')) {
                $this->skippedPaths[] = $this->filePathHelper->normalizePathAndSchema($value);
                continue;
            }

            if (file_exists($value)) {
                $this->skippedPaths[] = $this->filePathHelper->normalizePathAndSchema($value);
            }
        }

        return $this->skippedPaths;
    }
}
