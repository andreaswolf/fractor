<?php

declare(strict_types=1);

namespace a9f\FractorYaml;

use a9f\Fractor\Application\Contract\FileProcessor;
use a9f\Fractor\Application\ValueObject\File;
use a9f\Fractor\ValueObject\Indent;
use a9f\FractorYaml\Contract\YamlDumper;
use a9f\FractorYaml\Contract\YamlFractorRule;
use a9f\FractorYaml\Contract\YamlParser;
use Webmozart\Assert\Assert;

final readonly class YamlFileProcessor implements FileProcessor
{
    /**
     * @param iterable<YamlFractorRule> $rules
     */
    public function __construct(private iterable $rules, private YamlParser $yamlParser, private YamlDumper $yamlDumper)
    {
        Assert::allIsInstanceOf($this->rules, YamlFractorRule::class);
    }

    public function canHandle(File $file): bool
    {
        return in_array($file->getFileExtension(), $this->allowedFileExtensions(), true);
    }

    public function handle(File $file): void
    {
        $yaml = $this->yamlParser->parse($file);
        $indent = Indent::fromFile($file);

        $newYaml = $yaml;

        foreach ($this->rules as $rule) {
            $newYaml = $rule->refactor($newYaml);
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
}
