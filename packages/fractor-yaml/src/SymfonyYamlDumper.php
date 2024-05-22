<?php

declare(strict_types=1);

namespace a9f\FractorYaml;

use a9f\Fractor\ValueObject\Indent;
use a9f\FractorYaml\Contract\YamlDumper;
use Symfony\Component\Yaml\Yaml;

final class SymfonyYamlDumper implements YamlDumper
{
    public function dump(array $input, Indent $indent): string
    {
        return Yaml::dump($input, 99, $indent->length());
    }
}
