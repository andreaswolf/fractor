<?php

declare(strict_types=1);

namespace a9f\Fractor\Tests\Fixture\DummyProcessor\FileProcessor;

use a9f\Fractor\Application\Contract\FileProcessor;
use a9f\Fractor\Application\ValueObject\File;
use a9f\Fractor\Rules\RulesProvider;
use a9f\Fractor\Tests\Fixture\DummyProcessor\Contract\TextRule;

final readonly class TextFileProcessor implements FileProcessor
{
    /**
     * @param RulesProvider<TextRule> $rulesProvider
     */
    public function __construct(
        private RulesProvider $rulesProvider
    ) {
    }

    public function canHandle(File $file): bool
    {
        return $file->getFileExtension() === 'txt';
    }

    public function handle(File $file): void
    {
        foreach ($this->rulesProvider->getApplicableRules($file) as $rule) {
            $rule->apply($file);
        }
    }

    public function allowedFileExtensions(): array
    {
        return ['txt'];
    }
}
