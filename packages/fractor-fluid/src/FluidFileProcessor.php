<?php

declare(strict_types=1);

namespace a9f\FractorFluid;

use a9f\Fractor\Application\Contract\FileProcessor;
use a9f\Fractor\Application\ValueObject\AppliedRule;
use a9f\Fractor\Application\ValueObject\File;
use a9f\Fractor\Caching\Detector\ChangedFilesDetector;
use a9f\FractorFluid\Contract\FluidFractorRule;
use a9f\FractorFluid\ValueObject\FluidFormatConfiguration;

/**
 * @implements FileProcessor<FluidFractorRule>
 */
final readonly class FluidFileProcessor implements FileProcessor
{
    /**
     * @param iterable<FluidFractorRule> $rules
     */
    public function __construct(
        private iterable $rules,
        private ChangedFilesDetector $changedFilesDetector,
        private FluidFormatConfiguration $fluidFormatConfiguration
    ) {
    }

    public function canHandle(File $file): bool
    {
        return in_array($file->getFileExtension(), $this->allowedFileExtensions(), true);
    }

    public function handle(File $file, iterable $appliedRules): void
    {
        foreach ($appliedRules as $rule) {
            $newContent = $rule->refactor($file->getContent());

            if ($newContent !== $file->getContent()) {
                $file->changeFileContent($newContent);
                $file->addAppliedRule(AppliedRule::fromRule($rule));
            } else {
                $this->changedFilesDetector->addCachableFile($file->getFilePath());
            }
        }
    }

    /**
     * @return list<non-empty-string>
     */
    public function allowedFileExtensions(): array
    {
        return array_values($this->fluidFormatConfiguration->allowedFileExtensions);
    }

    public function getAllRules(): iterable
    {
        return $this->rules;
    }
}
