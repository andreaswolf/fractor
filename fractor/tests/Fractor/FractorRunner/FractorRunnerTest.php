<?php
declare(strict_types=1);

namespace Fractor\FractorRunner;

use a9f\Fractor\Testing\PHPUnit\AbstractFractorTestCase;

final class FractorRunnerTest extends AbstractFractorTestCase
{

    protected function provideConfigFilePath(): ?string
    {
        return __DIR__ . '/config/fractor.php';
    }

    public function test(): void
    {
        $this->doTest();
        $file = $this->fileCollector->getFileByPath(__DIR__ . '/Fixture/my_text_file.txt');
        self::assertStringEqualsFile(__DIR__ . '/Assertions/my_text_file.txt', $file->getContent());
    }

    protected function additionalConfigurationFiles(): array
    {
        return [
            __DIR__ . '/config/application.php'
        ];
    }
}