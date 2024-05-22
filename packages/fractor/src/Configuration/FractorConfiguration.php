<?php

declare(strict_types=1);

namespace a9f\Fractor\Configuration;

final class FractorConfiguration
{
    public static function configure(): FractorConfigurationBuilder
    {
        return new FractorConfigurationBuilder();
    }
}
