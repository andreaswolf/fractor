<?php

use a9f\Fractor\Configuration\FractorConfig;
use a9f\Fractor\Tests\Helper\FileProcessor\TextFileProcessor;

return static function (FractorConfig $config) {
    $config->setPaths([__DIR__ .'/../Fixture']);
    $config->setFileExtensions(['txt']);
    $config->withFileProcessor(TextFileProcessor::class);
};
