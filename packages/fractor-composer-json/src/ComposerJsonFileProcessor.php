<?php

declare(strict_types=1);

namespace a9f\FractorComposerJson;

use a9f\Fractor\Application\Contract\FileProcessor;
use a9f\Fractor\Application\ValueObject\AppliedRule;
use a9f\Fractor\Application\ValueObject\File;
use a9f\Fractor\ValueObject\Indent;
use a9f\FractorComposerJson\Contract\ComposerJsonFractorRule;
use a9f\FractorComposerJson\Contract\ComposerJsonPrinter;

final readonly class ComposerJsonFileProcessor implements FileProcessor
{
    /**
     * @param iterable<ComposerJsonFractorRule> $rules
     */
    public function __construct(
        private iterable $rules,
        private ComposerJsonPrinter $composerJsonPrinter,
        private ComposerJsonFactory $composerJsonFactory
    ) {
    }

    public function handle(File $file): void
    {
        $composerJson = $this->composerJsonFactory->createFromFile($file);
        $oldComposerJson = $this->composerJsonFactory->createFromFile($file);
        $ident = Indent::fromFile($file);

        foreach ($this->rules as $rule) {
            $rule->refactor($composerJson);

            if ($oldComposerJson->getJsonArray() !== $composerJson->getJsonArray()) {
                $file->changeFileContent($this->composerJsonPrinter->printToString($ident, $composerJson));
                $file->addAppliedRule(AppliedRule::fromRule($rule));
            }
        }
    }

    public function canHandle(File $file): bool
    {
        return $file->getFileName() === 'composer.json';
    }

    public function allowedFileExtensions(): array
    {
        return ['json'];
    }
}
