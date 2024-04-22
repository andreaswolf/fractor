<?php

declare(strict_types=1);

namespace a9f\Fractor\Tests\Fixture\DummyProcessor\FileProcessor;

use a9f\Fractor\Application\Contract\FileProcessor;
use a9f\Fractor\Application\ValueObject\File;
use a9f\Fractor\Tests\Fixture\DummyProcessor\Contract\TextRule;

final readonly class TextFileProcessor implements FileProcessor
{
    /**
     * @param TextRule[] $rules
     */
    public function __construct(private iterable $rules)
    {
    }

    public function canHandle(File $file): bool
    {
        return $file->getFileExtension() === 'txt';
    }

    public function handle(File $file): void
    {
        foreach ($this->rules as $rule) {
            $rule->apply($file);
        }
    }

    public function allowedFileExtensions(): array
    {
        return ['txt'];
    }
}
