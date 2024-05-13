<?php

use a9f\Fractor\Configuration\FractorConfiguration;
use a9f\Typo3Fractor\Set\Typo3SetList;

return FractorConfiguration::configure()
    ->withSets([Typo3SetList::TYPO3_10]);
