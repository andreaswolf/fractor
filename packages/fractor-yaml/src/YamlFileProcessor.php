<?php

declare(strict_types=1);

namespace a9f\FractorYaml;

use a9f\Fractor\Application\Contract\FileProcessor;
use a9f\Fractor\Application\ValueObject\AppliedRule;
use a9f\Fractor\Application\ValueObject\File;
use a9f\Fractor\ValueObject\Indent;
use a9f\FractorYaml\Contract\YamlDumper;
use a9f\FractorYaml\Contract\YamlFractorRule;
use a9f\FractorYaml\Contract\YamlParser;

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
        private YamlDumper $yamlDumper
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
            return;
        }

        $file->changeFileContent($this->yamlDumper->dump($newYaml, $indent));
    }

    public function allowedFileExtensions(): array
    {
        return ['yaml', 'yml'];
    }

    public function getAllRules(): iterable
    {
        return $this->rules;
    }
}
