<?php

declare(strict_types=1);

namespace a9f\FractorComposerJson;

use a9f\Fractor\Application\ValueObject\File;
use a9f\FractorComposerJson\ValueObject\ComposerJsonValueObject;

final class ComposerJsonFactory
{
    public function createFromFile(File $file): ComposerJsonValueObject
    {
        return ComposerJsonValueObject::fromFile($file);
    }
}
