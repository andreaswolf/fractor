<?php
declare(strict_types=1);

namespace a9f\Fractor\Tests\Helper\Contract;

use a9f\Fractor\Contract\FractorRule;

interface TextRule extends FractorRule
{
    public function apply(string $fileContent): string;
}