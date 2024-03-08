<?php

namespace a9f\Fractor;

use Symfony\Component\Console\Application;

final class FractorApplication extends Application
{
    public const NAME = 'Fractor';

    public function __construct()
    {
        parent::__construct(self::NAME, 'dev');
    }
}
