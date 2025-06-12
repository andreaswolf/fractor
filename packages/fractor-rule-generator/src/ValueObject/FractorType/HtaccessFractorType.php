<?php

declare(strict_types=1);

namespace a9f\FractorRuleGenerator\ValueObject\FractorType;

use a9f\FractorRuleGenerator\Contract\Typo3FractorTypeInterface;

class HtaccessFractorType implements Typo3FractorTypeInterface
{
    public function __toString(): string
    {
        return 'htaccess';
    }

    public function getFolderName(): string
    {
        return 'Htaccess';
    }

    public function getUseImports(): string
    {
        return <<<EOF
use a9f\FractorHtaccess\Contract\HtaccessFractorRule;
use Tivie\HtaccessParser\HtaccessContainer;
EOF;
    }

    public function getExtendsImplements(): string
    {
        return 'implements HtaccessFractorRule';
    }

    public function getTraits(): string
    {
        return '';
    }

    public function getFractorBodyTemplate(): string
    {
        return <<<'EOF'
    public function refactor(HtaccessContainer $node): HtaccessContainer
    {
    }
EOF;
    }

    public function getFractorFixtureFileExtension(): string
    {
        return 'htaccess';
    }
}
