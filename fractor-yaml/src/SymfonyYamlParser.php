<?php

declare(strict_types=1);

namespace a9f\FractorYaml;

use a9f\Fractor\Application\ValueObject\File;
use a9f\FractorYaml\Contract\YamlParser;
use a9f\FractorYaml\Exception\ParseException;
use Symfony\Component\Yaml\Exception\ParseException as YamlParseException;
use Symfony\Component\Yaml\Yaml;

final class SymfonyYamlParser implements YamlParser
{
    public function parse(File $file): array
    {
        try {
            return Yaml::parse($file->getContent(), Yaml::PARSE_CUSTOM_TAGS) ?? [];
        } catch (YamlParseException $parseException) {
            $parseException->setParsedFile($file->getFilePath());

            throw new ParseException($parseException->getMessage());
        }
    }
}
