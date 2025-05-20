<?php

declare(strict_types=1);

namespace a9f\Fractor\Tests\Configuration\FractorConfigurationBuilder;

use a9f\Fractor\Configuration\Option;
use a9f\Fractor\Testing\PHPUnit\AbstractFractorTestCase;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

final class FractorConfigurationBuilderTest extends AbstractFractorTestCase
{
    public function test(): void
    {
        $parameterBag = $this->getService(ParameterBagInterface::class);

        self::assertSame(
            [
                __DIR__,
            ],
            $parameterBag->get(Option::PATHS)
        );
    }

    public function provideConfigFilePath(): string
    {
        return __DIR__ . '/config/fractor.php';
    }
}
