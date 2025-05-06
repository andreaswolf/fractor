<?php

declare(strict_types=1);

namespace a9f\Typo3Fractor\TYPO3v13\Fluid;

use a9f\FractorFluid\Contract\FluidFractorRule;
use Nette\Utils\Strings;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @changelog https://docs.typo3.org/c/typo3/cms-core/main/en-us/Changelog/13.3/Deprecation-104789-FluidVariablesTrueFalseNull.html
 * @see \a9f\Typo3Fractor\Tests\TYPO3v13\Fluid\MigrateBooleanAndNullAttributeValuesToNativeTypesFractor\MigrateBooleanAndNullAttributeValuesToNativeTypesFractorTest
 */
final class MigrateBooleanAndNullAttributeValuesToNativeTypesFractor implements FluidFractorRule
{
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition('Migrate boolean and null attribute values to native types', [new CodeSample(
            <<<'CODE_SAMPLE'
<my:viewhelper foo="true" bar="1" />
<my:viewhelper foo="false" bar="0" />
<my:viewhelper foo="null" />
CODE_SAMPLE
            ,
            <<<'CODE_SAMPLE'
<my:viewhelper foo="{true}" bar="{true}" />
<my:viewhelper foo="{false}" bar="{false}" />
<my:viewhelper foo="{null}" />
CODE_SAMPLE
        )]);
    }

    public function refactor(string $fluid): string
    {
        return Strings::replace(
            $fluid,
            '~([a-zA-Z0-9_-]+)="(?P<value>true|false|null|TRUE|FALSE|1|0)"~',
            static function (array $matches): string {
                $value = strtolower((string) $matches['value']);
                if ($value === '1' || $value === 'true') {
                    $replacementValue = '{true}';
                } elseif ($value === '0' || $value === 'false') {
                    $replacementValue = '{false}';
                } else {
                    $replacementValue = '{null}';
                }
                return $matches[1] . '="' . $replacementValue . '"';
            }
        );
    }
}
