<?php

declare(strict_types=1);

namespace a9f\FractorFluid\Tests\FluidFileProcessor;

use a9f\FractorFluid\Configuration\FluidProcessorOption;
use a9f\FractorFluid\ValueObject\FluidFormatConfiguration;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

final class FluidFileProcessorConfigurationTest extends TestCase
{
    #[Test]
    public function defaultFileExtensions(): void
    {
        $parameterBag = new ParameterBag([]);
        $configuration = FluidFormatConfiguration::createFromParameterBag($parameterBag);

        self::assertSame(['html', 'xml', 'txt'], $configuration->allowedFileExtensions);
    }

    #[Test]
    public function customFileExtensions(): void
    {
        $parameterBag = new ParameterBag([
            FluidProcessorOption::ALLOWED_FILE_EXTENSIONS => ['html'],
        ]);
        $configuration = FluidFormatConfiguration::createFromParameterBag($parameterBag);

        self::assertSame(['html'], $configuration->allowedFileExtensions);
    }

    #[Test]
    public function multipleCustomFileExtensions(): void
    {
        $parameterBag = new ParameterBag([
            FluidProcessorOption::ALLOWED_FILE_EXTENSIONS => ['html', 'xml'],
        ]);
        $configuration = FluidFormatConfiguration::createFromParameterBag($parameterBag);

        self::assertSame(['html', 'xml'], $configuration->allowedFileExtensions);
    }
}
