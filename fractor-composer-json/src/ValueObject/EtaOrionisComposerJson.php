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
}
