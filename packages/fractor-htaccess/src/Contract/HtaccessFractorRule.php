<?php

declare(strict_types=1);

namespace a9f\FractorHtaccess\Contract;

use a9f\Fractor\Application\Contract\FractorRule;
use Tivie\HtaccessParser\HtaccessContainer;

interface HtaccessFractorRule extends FractorRule
{
    public function refactor(HtaccessContainer $node): HtaccessContainer;
}
