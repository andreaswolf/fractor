<?php

declare(strict_types=1);

namespace a9f\FractorYaml\Contract;

use a9f\Fractor\ValueObject\Indent;

interface YamlDumper
{
    /**
     * @param mixed[] $input
     */
    public function dump(array $input, Indent $indent): string;
}
