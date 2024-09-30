<?php

declare(strict_types=1);

namespace a9f\FractorRuleGenerator\FileSystem;

use a9f\Fractor\Exception\ShouldNotHappenException;
use a9f\FractorRuleGenerator\Finder\TemplateFinder;
use Nette\Utils\Strings;
use Rector\Testing\PHPUnit\StaticPHPUnitEnvironment;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\SplFileInfo;

final readonly class TemplateFileSystem
{
    /**
     * @var string
     * @see https://regex101.com/r/fw3jBe/1
     */
    private const FIXTURE_SHORT_REGEX = '#/Fixture/#';

    public function __construct(
        private Filesystem $filesystem
    ) {
    }

    /**
     * @param string[] $templateVariables
     */
    public function resolveDestination(
        SplFileInfo $smartFileInfo,
        array $templateVariables,
        string $targetDirectory
    ): string {
        $destination = $this->getRelativeFilePathFromDirectory($smartFileInfo, TemplateFinder::TEMPLATES_DIRECTORY);
        $destination = $this->applyVariables($destination, $templateVariables);

        // remove ".inc" protection from PHPUnit if not a test case
        if ($this->isNonFixtureFileWithIncSuffix($destination)) {
            $destination = Strings::before($destination, '.inc');
        }

        // special hack for tests, to PHPUnit doesn't load the generated file as test case
        /** @var string $destination */
        if (\str_ends_with($destination, 'Test.php') && StaticPHPUnitEnvironment::isPHPUnitRun()) {
            $destination .= '.inc';
        }

        return $targetDirectory . DIRECTORY_SEPARATOR . $destination;
    }

    /**
     * @param mixed[] $variables
     */
    private function applyVariables(string $content, array $variables): string
    {
        return str_replace(array_keys($variables), array_values($variables), $content);
    }

    private function isNonFixtureFileWithIncSuffix(string $filePath): bool
    {
        if (Strings::match($filePath, self::FIXTURE_SHORT_REGEX) !== null
            && Strings::match($filePath, self::FIXTURE_SHORT_REGEX) !== []
        ) {
            return false;
        }

        return \str_ends_with($filePath, '.inc');
    }

    private function getRelativeFilePathFromDirectory(SplFileInfo $fileInfo, string $directory): string
    {
        if (! file_exists($directory)) {
            throw new ShouldNotHappenException(sprintf(
                'Directory "%s" was not found in %s.',
                $directory,
                self::class
            ));
        }

        $relativeFilePath = $this->filesystem->makePathRelative(
            $this->getNormalizedRealPath($fileInfo),
            (string) realpath($directory)
        );
        return rtrim($relativeFilePath, '/');
    }

    private function getNormalizedRealPath(SplFileInfo $fileInfo): string
    {
        return $this->normalizePath($fileInfo->getRealPath());
    }

    private function normalizePath(string $path): string
    {
        return str_replace('\\', '/', $path);
    }
}
