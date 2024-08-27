<?php

declare(strict_types=1);

namespace a9f\FractorTypoScript\Factory;

use a9f\Fractor\Application\ValueObject\File;
use a9f\Fractor\ValueObject\Indent;
use Helmich\TypoScriptParser\Parser\Printer\PrettyPrinterConfiguration;

final class PrettyPrinterConfigurationFactory
{
    public function createPrettyPrinterConfiguration(File $file): PrettyPrinterConfiguration
    {
        // keep original TypoScript format
        $indent = Indent::fromFile($file);

        $prettyPrinterConfiguration = PrettyPrinterConfiguration::create();

        if ($indent->isSpace()) {
            $prettyPrinterConfiguration = $prettyPrinterConfiguration->withSpaceIndentation($indent->length());
        } else {
            $prettyPrinterConfiguration = $prettyPrinterConfiguration->withTabs();
        }

        return $prettyPrinterConfiguration->withEmptyLineBreaks();
    }
}
