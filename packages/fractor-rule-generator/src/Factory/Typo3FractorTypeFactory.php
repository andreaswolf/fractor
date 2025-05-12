<?php

declare(strict_types=1);

namespace a9f\FractorRuleGenerator\Factory;

use a9f\FractorRuleGenerator\Contract\Typo3FractorTypeInterface;
use a9f\FractorRuleGenerator\ValueObject\FractorType\ComposerJsonFractorType;
use a9f\FractorRuleGenerator\ValueObject\FractorType\FlexFormFractorType;
use a9f\FractorRuleGenerator\ValueObject\FractorType\FluidFractorType;
use a9f\FractorRuleGenerator\ValueObject\FractorType\HtaccessFractorType;
use a9f\FractorRuleGenerator\ValueObject\FractorType\TypoScriptFractorType;
use a9f\FractorRuleGenerator\ValueObject\FractorType\YamlFractorType;

final class Typo3FractorTypeFactory
{
    public static function fromString(string $type): Typo3FractorTypeInterface
    {
        return match ($type) {
            'composer' => new ComposerJsonFractorType(),
            'flexform' => new FlexFormFractorType(),
            'fluid' => new FluidFractorType(),
            'htaccess' => new HtaccessFractorType(),
            'typoscript' => new TypoScriptFractorType(),
            'yaml' => new YamlFractorType(),
            default => throw new \Exception('Invalid type given: ' . $type),
        };
    }
}
