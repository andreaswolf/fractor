<?php

declare(strict_types=1);

namespace a9f\Fractor\FileSystem\Skipper;

use a9f\Fractor\Configuration\ValueObject\SkipConfiguration;

final class SkippedPathsResolver
{
    /**
     * @readonly
     */
    private FilePathNormalizer $filePathNormalizer;

    /**
     * @readonly
     */
    private SkipConfiguration $skip;

    /**
     * @var null|string[]
     */
    private ?array $skippedPaths = null;

    public function __construct(FilePathNormalizer $filePathNormalizer, SkipConfiguration $skip)
    {
        $this->filePathNormalizer = $filePathNormalizer;
        $this->skip = $skip;
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

            if (strpos((string) $value, '*') !== false) {
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
