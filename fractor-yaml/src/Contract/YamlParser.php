<?php

declare(strict_types=1);

namespace a9f\FractorYaml\Contract;

use a9f\Fractor\Application\ValueObject\File;

interface YamlParser
{
    /**
     * @return mixed[]
     * /**
     */
    public function parse(File $file): array;
}
