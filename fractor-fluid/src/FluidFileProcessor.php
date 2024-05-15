<?php

declare(strict_types=1);

namespace a9f\FractorFluid;

use a9f\Fractor\Application\Contract\FileProcessor;
use a9f\Fractor\Application\ValueObject\AppliedRule;
use a9f\Fractor\Application\ValueObject\File;
use a9f\FractorFluid\Contract\FluidFractorRule;
use Webmozart\Assert\Assert;

final readonly class FluidFileProcessor implements FileProcessor
{
    /**
     * @param iterable<FluidFractorRule> $rules
     */
    public function __construct(
        private iterable $rules
    ) {
        Assert::allIsInstanceOf($this->rules, FluidFractorRule::class);
    }

    public function canHandle(File $file): bool
    {
        return in_array($file->getFileExtension(), $this->allowedFileExtensions(), true);
    }

    public function handle(File $file): void
    {
        foreach ($this->rules as $rule) {
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
}
