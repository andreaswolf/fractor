<?php

declare(strict_types=1);

namespace a9f\Fractor;

use Symfony\Component\Console\Application;

final class FractorApplication extends Application
{
    public const NAME = 'Fractor';

    private const FRACTOR_CONSOLE_VERSION = '0.2.1';

    public function __construct()
    {
        parent::__construct(self::NAME, self::FRACTOR_CONSOLE_VERSION);
    }
}
