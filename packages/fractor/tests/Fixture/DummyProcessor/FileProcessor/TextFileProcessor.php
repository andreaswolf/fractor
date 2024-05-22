<?php

declare(strict_types=1);

namespace a9f\Fractor\Tests\Fixture\DummyProcessor\FileProcessor;

use a9f\Fractor\Application\Contract\FileProcessor;
use a9f\Fractor\Application\ValueObject\File;
use a9f\Fractor\Tests\Fixture\DummyProcessor\Contract\TextRule;

/**
 * @implements FileProcessor<TextRule>
 */
final readonly class TextFileProcessor implements FileProcessor
{
    /**
     * @param iterable<TextRule> $rules
     */
    public function __construct(
        private iterable $rules
    ) {
    }

    public function canHandle(File $file): bool
    {
        return $file->getFileExtension() === 'txt';
    }

    public function handle(File $file, iterable $appliedRules): void
    {
        foreach ($appliedRules as $rule) {
            $rule->apply($file);
        }
    }

    public function allowedFileExtensions(): array
    {
        return ['txt'];
    }

    public function getAllRules(): iterable
    {
        return $this->rules;
    }
}
