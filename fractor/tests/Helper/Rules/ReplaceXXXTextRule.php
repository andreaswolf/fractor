<?php
declare(strict_types=1);

namespace a9f\Fractor\Tests\Helper\Rules;

use a9f\Fractor\Tests\Helper\Contract\TextRule;

final class ReplaceXXXTextRule implements TextRule
{

    public function apply(string $fileContent): string
    {
        return str_replace('XXX', 'YYY', $fileContent);
    }
}