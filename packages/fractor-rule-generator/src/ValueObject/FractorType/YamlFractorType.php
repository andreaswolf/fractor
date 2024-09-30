<?php

declare(strict_types=1);

namespace a9f\FractorRuleGenerator\ValueObject\FractorType;

use a9f\FractorRuleGenerator\Contract\Typo3FractorTypeInterface;

class YamlFractorType implements Typo3FractorTypeInterface
{
    public function __toString(): string
    {
        return 'yaml';
    }

    public function getFolderName(): string
    {
        return 'Yaml';
    }

    public function getUseImports(): string
    {
        return <<<EOF
use a9f\FractorYaml\Contract\YamlFractorRule;
EOF;
    }

    public function getExtendsImplements(): string
    {
        return 'implements YamlFractorRule';
    }

    public function getTraits(): string
    {
        return '';
    }

    public function getFractorBodyTemplate(): string
    {
        return <<<'EOF'
    public function refactor(array $yaml): array
    {
        return $yaml;
    }
EOF;
    }

    public function getFractorFixtureFileExtension(): string
    {
        return 'yaml';
    }
}
