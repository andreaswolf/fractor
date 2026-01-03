<?php

declare(strict_types=1);

namespace a9f\FractorXml\Tests\XmlFileProcessor;

use a9f\FractorXml\Configuration\XmlProcessorOption;
use a9f\FractorXml\ValueObject\XmlFormatConfiguration;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

final class XmlFileProcessorConfigurationTest extends TestCase
{
    #[Test]
    public function defaultFileExtensions(): void
    {
        $parameterBag = new ParameterBag([]);
        $configuration = XmlFormatConfiguration::createFromParameterBag($parameterBag);

        self::assertSame(['xml'], $configuration->allowedFileExtensions);
    }

    #[Test]
    public function customFileExtensions(): void
    {
        $parameterBag = new ParameterBag([
            XmlProcessorOption::ALLOWED_FILE_EXTENSIONS => ['xml', 'xlf'],
        ]);
        $configuration = XmlFormatConfiguration::createFromParameterBag($parameterBag);

        self::assertSame(['xml', 'xlf'], $configuration->allowedFileExtensions);
    }

    #[Test]
    public function multipleCustomFileExtensions(): void
    {
        $parameterBag = new ParameterBag([
            XmlProcessorOption::ALLOWED_FILE_EXTENSIONS => ['xml', 'xlf', 'xsd'],
        ]);
        $configuration = XmlFormatConfiguration::createFromParameterBag($parameterBag);

        self::assertSame(['xml', 'xlf', 'xsd'], $configuration->allowedFileExtensions);
    }
}
