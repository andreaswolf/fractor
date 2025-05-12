<?php

declare(strict_types=1);

namespace a9f\FractorHtaccess;

use a9f\Fractor\Application\Contract\FileProcessor;
use a9f\Fractor\Application\ValueObject\AppliedRule;
use a9f\Fractor\Application\ValueObject\File;
use a9f\Fractor\Caching\Detector\ChangedFilesDetector;
use a9f\FractorHtaccess\Contract\HtaccessFractorRule;
use Tivie\HtaccessParser\Exception\SyntaxException;
use Tivie\HtaccessParser\HtaccessContainer;
use Tivie\HtaccessParser\Parser;

/**
 * @implements FileProcessor<HtaccessFractorRule>
 */
final readonly class HtaccessFileProcessor implements FileProcessor
{
    /**
     * @param iterable<HtaccessFractorRule> $rules
     */
    public function __construct(
        private iterable $rules,
        private ChangedFilesDetector $changedFilesDetector,
        private Parser $parser
    ) {
    }

    public function canHandle(File $file): bool
    {
        return $file->getFileExtension() === 'htaccess';
    }

    public function handle(File $file, iterable $appliedRules): void
    {
        $filePath = $file->getFilePath();
        if (! file_exists($filePath) || ! is_readable($filePath)) {
            return;
        }

        $fileObject = new \SplFileObject($filePath);

        try {
            /** @var HtaccessContainer $originalHtaccess */
            $originalHtaccess = $this->parser->parse($fileObject);

            // Clone doesn't work here
            $workingHtaccess = unserialize(serialize($originalHtaccess));
            if (! $workingHtaccess instanceof HtaccessContainer) {
                throw new \RuntimeException('Deep copy via serialization failed.');
            }

            foreach ($appliedRules as $rule) {
                $stateBeforeRule = (string) $workingHtaccess;
                $workingHtaccess = $rule->refactor($workingHtaccess);
                $stateAfterRule = (string) $workingHtaccess;

                if ($stateBeforeRule !== $stateAfterRule) {
                    $file->addAppliedRule(AppliedRule::fromRule($rule));
                }
            }

            $originalContentString = (string) $originalHtaccess;
            $newContentString = (string) $workingHtaccess;

            if ($originalContentString === $newContentString) {
                $this->changedFilesDetector->addCachableFile($filePath);
                return;
            }

            $file->changeFileContent($newContentString);
        } catch (SyntaxException|\Throwable) {
            return;
        }
    }

    public function allowedFileExtensions(): array
    {
        return ['htaccess'];
    }

    public function getAllRules(): iterable
    {
        return $this->rules;
    }
}
