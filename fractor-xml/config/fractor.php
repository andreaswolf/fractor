<?php

use a9f\Fractor\Configuration\FractorConfig;
use a9f\FractorXml\DependencyInjection\XmlFractorCompilerPass;

return static function (FractorConfig $config) {
    $config->addCompilerPass(new XmlFractorCompilerPass());
};
