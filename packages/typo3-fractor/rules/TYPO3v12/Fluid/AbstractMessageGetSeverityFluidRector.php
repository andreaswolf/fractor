<?php

declare(strict_types=1);

namespace a9f\Typo3Fractor\TYPO3v12\Fluid;

use a9f\FractorFluid\Contract\FluidFractorRule;
use Nette\Utils\Strings;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @changelog https://docs.typo3.org/c/typo3/cms-core/main/en-us/Changelog/12.0/Breaking-97787-AbstractMessageGetSeverityReturnsContextualFeedbackSeverity.html
 */
final class AbstractMessageGetSeverityFluidRector implements FluidFractorRule
{
    /**
     * @var string
     */
    private const PATTERN = '#{status.severity}#imsU';

    /**
     * @var string
     */
    private const REPLACEMENT = '{status.severity.value}';

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition("Migrate to severity property 'value'", [
            new CodeSample(
                <<<'CODE_SAMPLE'
<div class="{severityClassMapping.{status.severity}}">
    <!-- stuff happens here -->
</div>
CODE_SAMPLE
                ,
                <<<'CODE_SAMPLE'
<div class="{severityClassMapping.{status.severity.value}}">
    <!-- stuff happens here -->
</div>
CODE_SAMPLE
            ),
        ]);
    }

    public function refactor(string $fluid): string
    {
        return Strings::replace($fluid, self::PATTERN, self::REPLACEMENT);
    }
}
