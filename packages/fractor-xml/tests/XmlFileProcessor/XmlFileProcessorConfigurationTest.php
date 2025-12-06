<?php

declare(strict_types=1);

namespace a9f\FractorXml\Tests\XmlFileProcessor;

use a9f\FractorXml\Configuration\XmlProcessorOption;
use a9f\FractorXml\ValueObject\XmlFormatConfiguration;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

final class XmlFileProcessorConfigurationTest extends TestCase
{
    public function testDefaultFileExtensions(): void
    {
        $parameterBag = new ParameterBag([]);
        $configuration = XmlFormatConfiguration::createFromParameterBag($parameterBag);

        self::assertSame(['xml'], $configuration->allowedFileExtensions);
    }

    public function testCustomFileExtensions(): void
    {
        $parameterBag = new ParameterBag([
            XmlProcessorOption::ALLOWED_FILE_EXTENSIONS => ['xml', 'xlf'],
        ]);
        $configuration = XmlFormatConfiguration::createFromParameterBag($parameterBag);

        self::assertSame(['xml', 'xlf'], $configuration->allowedFileExtensions);
    }

    public function testMultipleCustomFileExtensions(): void
    {
        $parameterBag = new ParameterBag([
            XmlProcessorOption::ALLOWED_FILE_EXTENSIONS => ['xml', 'xlf', 'xsd'],
        ]);
        $configuration = XmlFormatConfiguration::createFromParameterBag($parameterBag);

        self::assertSame(['xml', 'xlf', 'xsd'], $configuration->allowedFileExtensions);
    }
}
