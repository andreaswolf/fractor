<?php

declare(strict_types=1);

namespace a9f\FractorComposerJson\Contract;

use a9f\Fractor\Application\Contract\ConfigurableFractorRule;
use a9f\Fractor\Application\Contract\FractorRule;

interface ComposerJsonFractorRule extends FractorRule, ConfigurableFractorRule
{
    public function refactor(ComposerJson $composerJson): void;
}
