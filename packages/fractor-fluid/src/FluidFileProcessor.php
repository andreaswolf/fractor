<?php

declare(strict_types=1);

namespace a9f\FractorFluid;

use a9f\Fractor\Application\Contract\FileProcessor;
use a9f\Fractor\Application\ValueObject\AppliedRule;
use a9f\Fractor\Application\ValueObject\File;
use a9f\FractorFluid\Contract\FluidFractorRule;

/**
 * @implements FileProcessor<FluidFractorRule>
 */
final class FluidFileProcessor implements FileProcessor
{
    /**
     * @var iterable<FluidFractorRule>
     * @readonly
     */
    private iterable $rules;

    /**
     * @param iterable<FluidFractorRule> $rules
     */
    public function __construct(iterable $rules)
    {
        $this->rules = $rules;
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
            }
        }
    }

    public function allowedFileExtensions(): array
    {
        return ['html', 'xml', 'txt'];
    }

    public function getAllRules(): iterable
    {
        return $this->rules;
    }
}
