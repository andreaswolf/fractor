<?php

declare(strict_types=1);

namespace a9f\Fractor\Configuration;

final class FractorConfiguration
{
    private static ?FractorConfigurationBuilder $instance = null;

    public static function configure(): FractorConfigurationBuilder
    {
        if (! self::$instance instanceof FractorConfigurationBuilder) {
            self::$instance = new FractorConfigurationBuilder();
        }
        return self::$instance;
    }

    public static function reset(): void
    {
        self::$instance = null;
    }
}
