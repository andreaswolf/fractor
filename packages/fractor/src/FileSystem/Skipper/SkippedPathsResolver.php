<?php

declare(strict_types=1);

namespace a9f\Fractor\FileSystem\Skipper;

use a9f\Fractor\Configuration\ValueObject\SkipConfiguration;

final class SkippedPathsResolver
{
    /**
     * @var null|string[]
     */
    private null|array $skippedPaths = null;

    public function __construct(
        private readonly FilePathNormalizer $filePathNormalizer,
        private readonly SkipConfiguration $skip
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

        $this->skippedPaths = [];

        foreach ($this->skip->getSkip() as $key => $value) {
            if (! is_int($key)) {
                continue;
            }

            if (\str_contains((string) $value, '*')) {
                $this->skippedPaths[] = $this->filePathNormalizer->normalizePathAndSchema($value);
                continue;
            }

            if (file_exists($value)) {
                $this->skippedPaths[] = $this->filePathNormalizer->normalizePathAndSchema($value);
            }
        }

        return $this->skippedPaths;
    }
}
