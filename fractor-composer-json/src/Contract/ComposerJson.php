<?php

declare(strict_types=1);

namespace a9f\FractorComposerJson\Contract;

use a9f\FractorComposerJson\ValueObject\PackageAndVersion;

interface ComposerJson
{
    /**
     * @return mixed[]
     */
    public function getJsonArray(): array;

    public function addRequiredPackage(PackageAndVersion $packageAndVersion): void;

    public function toJsonString(): string;
}
