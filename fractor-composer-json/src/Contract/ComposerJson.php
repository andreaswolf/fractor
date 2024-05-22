<?php

declare(strict_types=1);

namespace a9f\FractorComposerJson\Contract;

use a9f\FractorComposerJson\ValueObject\PackageAndVersion;
use a9f\FractorComposerJson\ValueObject\RenamePackage;

interface ComposerJson
{
    /**
     * @return mixed[]
     */
    public function getJsonArray(): array;

    public function addRequiredPackage(PackageAndVersion $packageAndVersion): void;

    public function toJsonString(): string;

    public function addRequiredDevPackage(PackageAndVersion $packageAndVersion): void;

    public function changePackageVersion(PackageAndVersion $packageAndVersion): void;

    public function removePackage(string $packageName): void;

    public function hasRequiredPackage(string $packageName): bool;

    public function hasRequiredDevPackage(string $packageName): bool;

    public function replaceRequiredPackage(RenamePackage $renamePackage): void;

    public function replaceRequiredDevPackage(RenamePackage $renamePackage): void;
}
