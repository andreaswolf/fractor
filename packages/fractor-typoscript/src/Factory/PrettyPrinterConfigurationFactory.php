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

        if ($prettyPrinterFormatConfiguration->getStyle() === 'auto') {
            // keep original TypoScript format
            $indent = Indent::fromFile($file);

            if ($indent->isSpace()) {
                $prettyPrinterConfiguration = $prettyPrinterConfiguration->withSpaceIndentation($indent->length());
            } else {
                $prettyPrinterConfiguration = $prettyPrinterConfiguration->withTabs();
            }
        } elseif ($prettyPrinterFormatConfiguration->getStyle() === PrettyPrinterConfiguration::INDENTATION_STYLE_TABS) {
            $prettyPrinterConfiguration = $prettyPrinterConfiguration->withTabs();
        } else {
            $prettyPrinterConfiguration = $prettyPrinterConfiguration->withSpaceIndentation(
                $prettyPrinterFormatConfiguration->getSize()
            );
        }

        if ($prettyPrinterFormatConfiguration->shouldIndentConditions()) {
            $prettyPrinterConfiguration = $prettyPrinterConfiguration->withIndentConditions();
        }

        if ($prettyPrinterFormatConfiguration->shouldAddClosingGlobal()) {
            $prettyPrinterConfiguration = $prettyPrinterConfiguration->withClosingGlobalStatement();
        }

        if ($prettyPrinterFormatConfiguration->shouldIncludeEmptyLineBreaks()) {
            return $prettyPrinterConfiguration->withEmptyLineBreaks();
        }

        return $prettyPrinterConfiguration;
    }
}
