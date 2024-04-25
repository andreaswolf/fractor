<?php

declare(strict_types=1);

namespace a9f\Fractor\Testing\Contract;

interface FractorTestInterface
{
    public function provideConfigFilePath(): ?string;
}
