<?php

declare(strict_types=1);

namespace a9f\FractorComposerJson\Contract;

use a9f\Fractor\ValueObject\Indent;

interface ComposerJsonPrinter
{
    public function printToString(Indent $indent, ComposerJson $composerJson): string;
}
