<?php

declare(strict_types=1);

namespace a9f\FractorComposerJson\ValueObject;

use a9f\Fractor\Application\ValueObject\File;
use a9f\FractorComposerJson\Contract\ComposerJson;

final readonly class EtaOrionisComposerJson implements ComposerJson
{
    public function __construct(
        private \EtaOrionis\ComposerJsonManipulator\ComposerJson $composerJson
    ) {
    }

    public static function fromFile(File $file): self
    {
        return new self(\EtaOrionis\ComposerJsonManipulator\ComposerJson::fromFile($file->getFilePath()));
    }

    public function getJsonArray(): array
    {
        return $this->composerJson->getJsonArray();
    }

    public function addRequiredPackage(PackageAndVersion $packageAndVersion): void
    {
        $this->composerJson->addRequiredPackage($packageAndVersion->getPackageName(), $packageAndVersion->getVersion());
    }

    public function toJsonString(): string
    {
        return $this->composerJson->toJsonString($this->composerJson->getJsonArray());
    }

    public function addRequiredDevPackage(PackageAndVersion $packageAndVersion): void
    {
        $this->composerJson->addRequiredDevPackage(
            $packageAndVersion->getPackageName(),
            $packageAndVersion->getVersion()
        );
    }

    public function changePackageVersion(PackageAndVersion $packageAndVersion): void
    {
        $this->composerJson->changePackageVersion(
            $packageAndVersion->getPackageName(),
            $packageAndVersion->getVersion()
        );
    }

    public function removePackage(string $packageName): void
    {
        $this->composerJson->removePackage($packageName);
    }

    public function hasRequiredPackage(string $packageName): bool
    {
        return $this->composerJson->hasRequiredPackage($packageName);
    }

    public function hasRequiredDevPackage(string $packageName): bool
    {
        return $this->composerJson->hasRequiredDevPackage($packageName);
    }

    public function replaceRequiredPackage(RenamePackage $renamePackage): void
    {
        $version = $this->composerJson->getRequire()[$renamePackage->getOldPackageName()];
        $this->replacePackage($version, $renamePackage);
    }

    public function replaceRequiredDevPackage(RenamePackage $renamePackage): void
    {
        $version = $this->composerJson->getRequireDev()[$renamePackage->getOldPackageName()];
        $this->replacePackage($version, $renamePackage);
    }

    public function replacePackage(string $version, RenamePackage $renamePackage): void
    {
        $this->composerJson->replacePackage(
            $renamePackage->getOldPackageName(),
            $renamePackage->getNewPackageName(),
            $version
        );
    }
}
