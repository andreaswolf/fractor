<?php

declare(strict_types=1);

namespace a9f\FractorRuleGenerator\ValueObject\FractorType;

use a9f\FractorRuleGenerator\Contract\Typo3FractorTypeInterface;

class ComposerJsonFractorType implements Typo3FractorTypeInterface
{
    public function __toString(): string
    {
        return 'composer';
    }

    public function getFolderName(): string
    {
        return 'Composer';
    }

    public function getUseImports(): string
    {
        return <<<EOF
use a9f\FractorComposerJson\Contract\ComposerJson;
use a9f\FractorComposerJson\Contract\ComposerJsonFractorRule;
EOF;
    }

    public function getExtendsImplements(): string
    {
        return 'implements ComposerJsonFractorRule';
    }

    public function getTraits(): string
    {
        return '';
    }

    public function getFractorBodyTemplate(): string
    {
        return <<<'EOF'
    public function refactor(ComposerJson $composerJson): void
    {
    }

    public function configure(array $configuration): void
    {
    }
EOF;
    }

    public function getFractorFixtureFileExtension(): string
    {
        return 'json';
    }
}
