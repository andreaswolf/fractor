<?php

declare(strict_types=1);

namespace a9f\Fractor\Configuration;

use a9f\Fractor\DependencyInjection\FractorContainerFactory;

/**
 * Factory for {@see FractorConfigurationBuilder} instances.
 *
 * An instance is created by {@see FractorContainerFactory} when starting the DI container build process
 * and destroyed after the process was finished.
 */
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
