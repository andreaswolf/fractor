<?php

declare(strict_types=1);

use a9f\Fractor\Configuration\FractorConfiguration;
use a9f\Fractor\ValueObject\Indent;
use a9f\FractorXml\Configuration\XmlProcessorOption;
use a9f\Typo3Fractor\Set\Typo3LevelSetList;

return FractorConfiguration::configure()
    ->withPaths([__DIR__ . '/result/'])
    ->withSets([Typo3LevelSetList::UP_TO_TYPO3_13])
    ->withOptions([
        XmlProcessorOption::INDENT_CHARACTER => Indent::STYLE_TAB,
        XmlProcessorOption::INDENT_SIZE => 1,
    ]);
