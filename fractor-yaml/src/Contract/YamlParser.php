<?php

declare(strict_types=1);

namespace a9f\FractorYaml\Contract;

use a9f\Fractor\Application\ValueObject\File;
use a9f\FractorYaml\Exception\ParseException;

interface YamlParser
{
    /**
     * @return mixed[]
     * @throws ParseException
     * /**
     */
    public function parse(File $file): array;
}
