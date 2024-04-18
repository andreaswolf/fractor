<?php

declare(strict_types=1);

namespace Fractor\FractorRunner;

use a9f\Fractor\Testing\PHPUnit\AbstractFractorTestCase;

final class FractorRunnerTest extends AbstractFractorTestCase
{
    public function test(): void
    {
        $this->doTest();
    }

    protected function additionalConfigurationFiles(): array
    {
        return [
            __DIR__ . '/config/application.php'
        ];
    }
}
