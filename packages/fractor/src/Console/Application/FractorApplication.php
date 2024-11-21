<?php

declare(strict_types=1);

namespace a9f\Fractor\Console\Application;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputDefinition;

final class FractorApplication extends Application
{
    public const NAME = 'Fractor';

    private const FRACTOR_CONSOLE_VERSION = '0.4.1';

    public function __construct()
    {
        parent::__construct(self::NAME, self::FRACTOR_CONSOLE_VERSION);
    }

    protected function getDefaultInputDefinition(): InputDefinition
    {
        $defaultInputDefinition = parent::getDefaultInputDefinition();
        $this->removeUnusedOptions($defaultInputDefinition);
        return $defaultInputDefinition;
    }

    private function removeUnusedOptions(InputDefinition $inputDefinition): void
    {
        $options = $inputDefinition->getOptions();
        unset($options['quiet'], $options['no-interaction']);
        $inputDefinition->setOptions($options);
    }
}
