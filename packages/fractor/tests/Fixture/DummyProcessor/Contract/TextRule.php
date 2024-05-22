<?php

declare(strict_types=1);

namespace a9f\Fractor\Tests\Fixture\DummyProcessor\Contract;

use a9f\Fractor\Application\Contract\FractorRule;
use a9f\Fractor\Application\ValueObject\File;

interface TextRule extends FractorRule
{
    public function apply(File $file): void;
}
