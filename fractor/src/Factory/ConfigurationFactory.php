<?php
declare(strict_types=1);

namespace a9f\Fractor\Factory;

use a9f\Fractor\Configuration\FractorConfig;
use a9f\Fractor\ValueObject\Configuration;

final class ConfigurationFactory
{
    public function createFromFractorConfig(FractorConfig $fractorConfig): Configuration
    {
        return new Configuration($fractorConfig->getFileExtensions(), $fractorConfig->getPaths());
    }
}