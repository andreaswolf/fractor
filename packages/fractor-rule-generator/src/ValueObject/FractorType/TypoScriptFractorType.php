<?php

declare(strict_types=1);

namespace a9f\FractorRuleGenerator\ValueObject\FractorType;

use a9f\FractorRuleGenerator\Contract\Typo3FractorTypeInterface;

final class TypoScriptFractorType implements Typo3FractorTypeInterface
{
    public function __toString(): string
    {
        return 'typoscript';
    }

    public function getFolderName(): string
    {
        return 'TypoScript';
    }

    public function getUseImports(): string
    {
        return <<<EOF
use a9f\FractorTypoScript\AbstractTypoScriptFractor;
use Helmich\TypoScriptParser\Parser\AST\Statement;
EOF;
    }

    public function getExtendsImplements(): string
    {
        return 'extends AbstractTypoScriptFractor';
    }

    public function getTraits(): string
    {
        return '';
    }

    public function getFractorBodyTemplate(): string
    {
        return <<<'EOF'
    public function refactor(Statement $statement): null|Statement|int
    {
        return $statement;
    }
EOF;
    }

    public function getFractorFixtureFileExtension(): string
    {
        return 'typoscript';
    }
}
