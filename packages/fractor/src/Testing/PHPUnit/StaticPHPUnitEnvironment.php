<?php

declare(strict_types=1);

namespace a9f\Fractor\Testing\PHPUnit;

final class StaticPHPUnitEnvironment
{
    public static function isPHPUnitRun(): bool
    {
        return \defined('PHPUNIT_COMPOSER_INSTALL');
    }
}
