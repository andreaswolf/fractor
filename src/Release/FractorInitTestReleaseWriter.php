<?php

declare(strict_types=1);

namespace a9f\FractorMonorepo\Release;

use Nette\Utils\FileSystem;
use Nette\Utils\Strings;

final class FractorInitTestReleaseWriter
{
    public function write(string $version): void
    {
        $typo3FractorInitFile = __DIR__ . '/../../packages/typo3-fractor/tests/Functional/Bin/InitCommandTest.php';
        $content = Filesystem::read($typo3FractorInitFile);
        $content = Strings::replace($content, '/(->setVersion\(\')\d+\.\d+\.\d+/', '->setVersion(\'' . $version);
        FileSystem::write($typo3FractorInitFile, $content);
    }

    public function getDescription(string $version): string
    {
        return \sprintf(
            'Add "%s" to "%s"',
            $version,
            'packages/typo3-fractor/tests/Functional/Bin/InitCommandTest.php'
        );
    }
}
