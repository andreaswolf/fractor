<?php

declare(strict_types=1);

namespace a9f\FractorMonorepo\Release;

use a9f\Fractor\Console\Application\FractorApplication;
use Nette\Utils\FileSystem;
use Nette\Utils\Strings;

final class FractorApplicationReleaseWriter
{
    public function write(string $version): void
    {
        $applicationFile = __DIR__ . '/../../packages/fractor/src/FractorApplication.php';
        $content = Filesystem::read($applicationFile);
        $content = Strings::replace(
            $content,
            '/(const FRACTOR_CONSOLE_VERSION = \')\d+\.\d+\.\d+/',
            'const FRACTOR_CONSOLE_VERSION = \'' . $version
        );
        FileSystem::write($applicationFile, $content);
    }

    public function getDescription(string $version): string
    {
        return \sprintf('Add "%s" to "%s"', $version, FractorApplication::class);
    }
}
