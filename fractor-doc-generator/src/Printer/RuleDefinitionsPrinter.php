<?php

declare(strict_types=1);

namespace a9f\FractorDocGenerator\Printer;

use Symplify\RuleDocGenerator\Text\KeywordHighlighter;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

final readonly class RuleDefinitionsPrinter
{
    public function __construct(
        private CodeSamplePrinter  $codeSamplePrinter,
        private KeywordHighlighter $keywordHighlighter,
    ) {
    }

    /**
     * @param RuleDefinition[] $ruleDefinitions
     * @return string[]
     */
    public function print(array $ruleDefinitions): array
    {
        $ruleCount = count($ruleDefinitions);

        $lines = [];
        $lines[] = sprintf('# %d Rules Overview', $ruleCount);

        return $this->printRuleDefinitions($ruleDefinitions, $lines);
    }

    /**
     * @param RuleDefinition[] $ruleDefinitions
     * @param string[] $lines
     * @return string[]
     */
    private function printRuleDefinitions(array $ruleDefinitions, array $lines): array
    {
        foreach ($ruleDefinitions as $ruleDefinition) {
            $lines[] = '## ' . $ruleDefinition->getRuleShortClass();

            $lines[] = $this->keywordHighlighter->highlight($ruleDefinition->getDescription());

            if ($ruleDefinition->isConfigurable()) {
                $lines[] = ':wrench: **configure it!**';
            }

            $lines[] = '- class: [`' . $ruleDefinition->getRuleClass() . '`](' . $ruleDefinition->getRuleFilePath() . ')';

            $codeSampleLines = $this->codeSamplePrinter->print($ruleDefinition);
            $lines = array_merge($lines, $codeSampleLines);
        }

        return $lines;
    }
}
