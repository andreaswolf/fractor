<?php

use a9f\Fractor\Configuration\FractorConfig;
use a9f\FractorXml\XmlFileProcessor;
use a9f\Typo3Fractor\Rules\FlexForm\AddRenderTypeToFlexFormFractor;

return static function (FractorConfig $config) {
    $config->import(__DIR__ . '/../vendor/a9f/fractor-xml/config/fractor.php');

    $config->setPaths([
        __DIR__ . '/output/',
    ]);

    $config->withFileProcessor(XmlFileProcessor::class);

    $config->withRule(AddRenderTypeToFlexFormFractor::class);
};
