<?php

declare(strict_types=1);

namespace a9f\Fractor\Application;

use a9f\Fractor\Application\Contract\FractorRule;
use a9f\Fractor\Configuration\ValueObject\SkipConfiguration;
use a9f\Fractor\FileSystem\Skipper\FileInfoMatcher;

final readonly class RuleSkipper
{
    public function __construct(
        private SkipConfiguration $configuration,
        private FileInfoMatcher $fileInfoMatcher
    ) {
    }

    /**
     * @param class-string<FractorRule> $rule
     * @param string $filePath Relative path to the file
     */
    public function shouldSkip(string $rule, string $filePath): bool
    {
        $configuredSkip = $this->configuration->getSkip();
        if (in_array($rule, $configuredSkip)) {
            return true;
        }

        if (array_key_exists($rule, $configuredSkip)) {
            $skippedPaths = $configuredSkip[$rule];

            if (is_string($skippedPaths)) {
                $skippedPaths = [$skippedPaths];
            }

            return $this->fileInfoMatcher->doesFilePathMatchAnyPattern($filePath, $skippedPaths);
        }

        return false;
    }
}
