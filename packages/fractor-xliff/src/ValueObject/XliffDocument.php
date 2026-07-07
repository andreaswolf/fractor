<?php

declare(strict_types=1);

namespace a9f\FractorXliff\ValueObject;

use a9f\Fractor\Application\ValueObject\File;

final readonly class XliffDocument
{
    public function __construct(
        public \DOMDocument $document,
        public XliffVersion $version,
        public File $file,
    ) {
    }
}
