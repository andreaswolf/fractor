<?php
declare(strict_types=1);

namespace a9f\Fractor\Tests\Helper\FileProcessor;

use a9f\Fractor\Contract\FileProcessor;
use a9f\Fractor\Tests\Helper\Contract\TextRule;
use a9f\Fractor\ValueObject\File;

final readonly class TextFileProcessor implements FileProcessor
{
    /**
     * @param list<TextRule> $rules
     */
    public function __construct(private iterable $rules)
    {
    }

    public function canHandle(\SplFileInfo $file): bool
    {
        return $file->getExtension() === 'txt';
    }

    public function handle(File $file): void
    {
        foreach ($this->rules as $rule) {
            $rule->apply($file);
        }
    }
}