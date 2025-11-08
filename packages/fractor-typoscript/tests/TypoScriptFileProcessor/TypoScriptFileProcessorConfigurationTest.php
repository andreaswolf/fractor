<?php

declare(strict_types=1);

namespace a9f\FractorTypoScript\Tests\TypoScriptFileProcessor;

use a9f\FractorTypoScript\Configuration\TypoScriptProcessorOption;
use a9f\FractorTypoScript\ValueObject\TypoScriptPrettyPrinterFormatConfiguration;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

final class TypoScriptFileProcessorConfigurationTest extends TestCase
{
    public function testDefaultFileExtensions(): void
    {
        $parameterBag = new ParameterBag([]);
        $configuration = TypoScriptPrettyPrinterFormatConfiguration::createFromParameterBag($parameterBag);

        self::assertSame(['typoscript', 'tsconfig', 'ts'], $configuration->allowedFileExtensions);
    }

    public function testCustomFileExtensions(): void
    {
        $parameterBag = new ParameterBag([
            TypoScriptProcessorOption::ALLOWED_FILE_EXTENSIONS => ['typoscript', 'tss'],
        ]);
        $configuration = TypoScriptPrettyPrinterFormatConfiguration::createFromParameterBag($parameterBag);

        self::assertSame(['typoscript', 'tss'], $configuration->allowedFileExtensions);
    }

    public function testMultipleCustomFileExtensions(): void
    {
        $parameterBag = new ParameterBag([
            TypoScriptProcessorOption::ALLOWED_FILE_EXTENSIONS => ['typoscript', 'tsconfig', 'tss', 'tsc'],
        ]);
        $configuration = TypoScriptPrettyPrinterFormatConfiguration::createFromParameterBag($parameterBag);

        self::assertSame(['typoscript', 'tsconfig', 'tss', 'tsc'], $configuration->allowedFileExtensions);
    }
}
