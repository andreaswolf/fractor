<?php

use a9f\Fractor\Configuration\FractorConfig;

return static function (FractorConfig $config) {
    $config->setPaths([__DIR__ . '/../Fixture/']);
    $config->setFileExtensions(['txt']);
};
