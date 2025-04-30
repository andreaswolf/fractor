<?php

declare(strict_types=1);

namespace a9f\FractorTypoScript\Factory;

use a9f\Fractor\Application\ValueObject\File;
use a9f\Fractor\ValueObject\Indent;
use a9f\FractorTypoScript\ValueObject\TypoScriptPrettyPrinterFormatConfiguration;
use Helmich\TypoScriptParser\Parser\Printer\PrettyPrinterConfiguration;

final class PrettyPrinterConfigurationFactory
{
    public function createPrettyPrinterConfiguration(
        File $file,
        TypoScriptPrettyPrinterFormatConfiguration $prettyPrinterFormatConfiguration
    ): PrettyPrinterConfiguration {
        $prettyPrinterConfiguration = PrettyPrinterConfiguration::create();

        if ($prettyPrinterFormatConfiguration->style === 'auto') {
            // keep original TypoScript format
            $indent = Indent::fromFile($file);

            if ($indent->isSpace()) {
                $prettyPrinterConfiguration = $prettyPrinterConfiguration->withSpaceIndentation($indent->length());
            } else {
                $prettyPrinterConfiguration = $prettyPrinterConfiguration->withTabs();
            }
        } elseif ($prettyPrinterFormatConfiguration->style === PrettyPrinterConfiguration::INDENTATION_STYLE_TABS) {
            $prettyPrinterConfiguration = $prettyPrinterConfiguration->withTabs();
        } else {
            $prettyPrinterConfiguration = $prettyPrinterConfiguration->withSpaceIndentation(
                $prettyPrinterFormatConfiguration->size
            );
        }

        if ($prettyPrinterFormatConfiguration->indentConditions) {
            $prettyPrinterConfiguration = $prettyPrinterConfiguration->withIndentConditions();
        }

        if ($prettyPrinterFormatConfiguration->addClosingGlobal) {
            $prettyPrinterConfiguration = $prettyPrinterConfiguration->withClosingGlobalStatement();
        }

        if ($prettyPrinterFormatConfiguration->includeEmptyLineBreaks) {
            $prettyPrinterConfiguration = $prettyPrinterConfiguration->withEmptyLineBreaks();
        }

        return $prettyPrinterConfiguration->withConditionTermination(
            $prettyPrinterFormatConfiguration->conditionTermination
        );
    }
}
