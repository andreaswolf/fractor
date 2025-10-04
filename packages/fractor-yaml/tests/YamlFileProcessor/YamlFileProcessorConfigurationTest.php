<?php

declare(strict_types=1);

namespace a9f\FractorYaml\Tests\YamlFileProcessor;

use a9f\FractorYaml\Configuration\YamlProcessorOption;
use a9f\FractorYaml\ValueObject\YamlFormatConfiguration;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

final class YamlFileProcessorConfigurationTest extends TestCase
{
    public function testDefaultFileExtensions(): void
    {
        $parameterBag = new ParameterBag([]);
        $configuration = YamlFormatConfiguration::createFromParameterBag($parameterBag);

        self::assertSame(['yaml', 'yml'], $configuration->allowedFileExtensions);
    }

    public function testCustomFileExtensions(): void
    {
        $parameterBag = new ParameterBag([
            YamlProcessorOption::ALLOWED_FILE_EXTENSIONS => ['yaml'],
        ]);
        $configuration = YamlFormatConfiguration::createFromParameterBag($parameterBag);

        self::assertSame(['yaml'], $configuration->allowedFileExtensions);
    }

    public function testMultipleCustomFileExtensions(): void
    {
        $parameterBag = new ParameterBag([
            YamlProcessorOption::ALLOWED_FILE_EXTENSIONS => ['yaml', 'yml', 'yaml.dist'],
        ]);
        $configuration = YamlFormatConfiguration::createFromParameterBag($parameterBag);

        self::assertSame(['yaml', 'yml', 'yaml.dist'], $configuration->allowedFileExtensions);
    }
}
