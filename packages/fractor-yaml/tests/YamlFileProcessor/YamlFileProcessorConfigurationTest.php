<?php

declare(strict_types=1);

namespace a9f\FractorYaml\Tests\YamlFileProcessor;

use a9f\FractorYaml\Configuration\YamlProcessorOption;
use a9f\FractorYaml\ValueObject\YamlFormatConfiguration;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

final class YamlFileProcessorConfigurationTest extends TestCase
{
    #[Test]
    public function defaultFileExtensions(): void
    {
        $parameterBag = new ParameterBag([]);
        $configuration = YamlFormatConfiguration::createFromParameterBag($parameterBag);

        self::assertSame(['yaml', 'yml'], $configuration->allowedFileExtensions);
    }

    #[Test]
    public function customFileExtensions(): void
    {
        $parameterBag = new ParameterBag([
            YamlProcessorOption::ALLOWED_FILE_EXTENSIONS => ['yaml'],
        ]);
        $configuration = YamlFormatConfiguration::createFromParameterBag($parameterBag);

        self::assertSame(['yaml'], $configuration->allowedFileExtensions);
    }

    #[Test]
    public function multipleCustomFileExtensions(): void
    {
        $parameterBag = new ParameterBag([
            YamlProcessorOption::ALLOWED_FILE_EXTENSIONS => ['yaml', 'yml', 'yaml.dist'],
        ]);
        $configuration = YamlFormatConfiguration::createFromParameterBag($parameterBag);

        self::assertSame(['yaml', 'yml', 'yaml.dist'], $configuration->allowedFileExtensions);
    }
}
