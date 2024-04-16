<?php
declare(strict_types=1);

namespace a9f\Fractor\Tests\Helper\Contract;

use a9f\Fractor\Contract\FractorRule;
use a9f\Fractor\ValueObject\File;

interface TextRule
{
    public function apply(File $file): void;
}