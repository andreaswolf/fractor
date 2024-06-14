<?php

declare(strict_types=1);

use a9f\Fractor\Configuration\FractorConfiguration;
use a9f\Fractor\ValueObject\Indent;
use a9f\FractorXml\Configuration\XmlProcessorOption;
use a9f\Typo3Fractor\TYPO3v12\FlexForm\MigrateInternalTypeFolderToTypeFolderFlexFormFractor;

return FractorConfiguration::configure()
    ->withOptions([
        XmlProcessorOption::INDENT_CHARACTER => Indent::STYLE_TAB,
        XmlProcessorOption::INDENT_SIZE => 1,
    ])
    ->withRules([MigrateInternalTypeFolderToTypeFolderFlexFormFractor::class]);
