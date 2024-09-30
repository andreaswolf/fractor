<?php

declare(strict_types=1);

namespace a9f\FractorRuleGenerator\ValueObject\FractorType;

use a9f\FractorRuleGenerator\Contract\Typo3FractorTypeInterface;

final class FlexFormFractorType implements Typo3FractorTypeInterface
{
    public function __toString(): string
    {
        return 'flexform';
    }

    public function getFolderName(): string
    {
        return 'FlexForm';
    }

    public function getUseImports(): string
    {
        return <<<EOF
use a9f\Typo3Fractor\AbstractFlexformFractor;
use a9f\Typo3Fractor\Helper\FlexFormHelperTrait;
EOF;
    }

    public function getExtendsImplements(): string
    {
        return 'extends AbstractFlexformFractor';
    }

    public function getTraits(): string
    {
        return <<<'EOF'

    use FlexFormHelperTrait;

EOF;
    }

    public function getFractorBodyTemplate(): string
    {
        return <<<'EOF'
    public function refactor(\DOMNode $node): \DOMNode|int|null
    {
    }
EOF;
    }

    public function getFractorFixtureFileExtension(): string
    {
        return 'xml';
    }
}
