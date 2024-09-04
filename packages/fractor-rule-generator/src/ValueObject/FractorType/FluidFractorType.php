<?php

declare(strict_types=1);

namespace a9f\FractorRuleGenerator\ValueObject\FractorType;

use a9f\FractorRuleGenerator\Contract\Typo3FractorTypeInterface;

class FluidFractorType implements Typo3FractorTypeInterface
{
    public function __toString(): string
    {
        return 'fluid';
    }

    public function getFolderName(): string
    {
        return 'Fluid';
    }

    public function getUseImports(): string
    {
        return <<<EOF
use a9f\FractorFluid\Contract\FluidFractorRule;
EOF;
    }

    public function getExtendsImplements(): string
    {
        return 'implements FluidFractorRule';
    }

    public function getTraits(): string
    {
        return '';
    }

    public function getFractorBodyTemplate(): string
    {
        return <<<'EOF'
    public function refactor(string $fluid): string
    {
        return 'TODO';
    }
EOF;
    }

    public function getFractorFixtureFileExtension(): string
    {
        return 'html';
    }
}
