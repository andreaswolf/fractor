<?php

declare(strict_types=1);

namespace a9f\FractorYaml;

use a9f\Fractor\Application\Contract\FileProcessor;
use a9f\Fractor\Application\ValueObject\AppliedRule;
use a9f\Fractor\Application\ValueObject\File;
use a9f\Fractor\Caching\Detector\ChangedFilesDetector;
use a9f\Fractor\ValueObject\Indent;
use a9f\FractorYaml\Contract\YamlDumper;
use a9f\FractorYaml\Contract\YamlFractorRule;
use a9f\FractorYaml\Contract\YamlParser;
use a9f\FractorYaml\ValueObject\YamlFormatConfiguration;

/**
 * @implements FileProcessor<YamlFractorRule>
 */
final readonly class YamlFileProcessor implements FileProcessor
{
    /**
     * @param iterable<YamlFractorRule> $rules
     */
    public function __construct(
        private iterable $rules,
        private YamlParser $yamlParser,
        private YamlDumper $yamlDumper,
        private ChangedFilesDetector $changedFilesDetector,
        private YamlFormatConfiguration $yamlFormatConfiguration
    ) {
    }

    public function canHandle(File $file): bool
    {
        return in_array($file->getFileExtension(), $this->allowedFileExtensions(), true);
    }

    public function handle(File $file, iterable $appliedRules): void
    {
        $yaml = $this->yamlParser->parse($file);
        $indent = Indent::fromFile($file);

        $newYaml = $yaml;

        foreach ($appliedRules as $rule) {
            $oldYaml = $newYaml;
            $newYaml = $rule->refactor($newYaml);

            if ($oldYaml !== $newYaml) {
                $file->addAppliedRule(AppliedRule::fromRule($rule));
            }
        }

        // Nothing has changed.
        if ($newYaml === $yaml) {
            $this->changedFilesDetector->addCachableFile($file->getFilePath());
            return;
        }

        $file->changeFileContent($this->yamlDumper->dump($newYaml, $indent));
    }

    /**
     * @return list<non-empty-string>
     */
    public function allowedFileExtensions(): array
    {
        return $this->yamlFormatConfiguration->allowedFileExtensions;
    }

    public function getAllRules(): iterable
    {
        return $this->rules;
    }
}
