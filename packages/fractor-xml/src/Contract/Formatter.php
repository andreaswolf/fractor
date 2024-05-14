<?php

declare(strict_types=1);

namespace a9f\FractorXml\Contract;

use a9f\Fractor\ValueObject\Indent;

interface Formatter
{
    public function format(Indent $indent, string $content): string;
}
