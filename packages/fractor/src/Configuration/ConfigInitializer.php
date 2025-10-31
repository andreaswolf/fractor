<?php

declare(strict_types=1);

namespace a9f\Fractor\Configuration;

use a9f\Fractor\Application\Contract\FractorRule;
use a9f\Fractor\FileSystem\InitFilePathsResolver;
use Nette\Utils\FileSystem;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;

final class ConfigInitializer
{
    /**
     * @var FractorRule[]
     */
    private array $fractors;

    /**
     * @param RewindableGenerator<FractorRule>|FractorRule[] $fractors
     */
    public function __construct(
        iterable $fractors,
        private readonly InitFilePathsResolver $initFilePathsResolver,
        private readonly SymfonyStyle $symfonyStyle,
    ) {
        if ($fractors instanceof RewindableGenerator) {
            $this->fractors = iterator_to_array($fractors->getIterator());
        } else {
            /** @var FractorRule[] $fractors */
            $this->fractors = $fractors;
        }
    }

    public function createConfig(string $projectDirectory): void
    {
        $commonFractorConfigPath = $projectDirectory . '/fractor.php';

        if (file_exists($commonFractorConfigPath)) {
            $this->symfonyStyle->warning('Register rules or sets in your "fractor.php" config');
            return;
        }

        $response = $this->symfonyStyle->ask('No "fractor.php" config found. Should we generate it for you?', 'yes');
        // be tolerant about input
        if (! in_array($response, ['yes', 'YES', 'y', 'Y'], true)) {
            // okay, nothing we can do
            return;
        }

        $configContents = FileSystem::read(__DIR__ . '/../../templates/fractor.php.dist');
        $configContents = $this->replacePathsContents($configContents, $projectDirectory);

        FileSystem::write($commonFractorConfigPath, $configContents, null);
        $this->symfonyStyle->success('The config is added now. Re-run command to make Fractor do the work!');
    }

    public function areSomeFractorsLoaded(): bool
    {
        return $this->fractors !== [];
    }

    private function replacePathsContents(string $rectorPhpTemplateContents, string $projectDirectory): string
    {
        $projectPhpDirectories = $this->initFilePathsResolver->resolve($projectDirectory);

        // fallback to default 'src' in case of empty one
        if ($projectPhpDirectories === []) {
            $projectPhpDirectories[] = 'src';
        }

        $projectPhpDirectoriesContents = '';
        foreach ($projectPhpDirectories as $projectPhpDirectory) {
            $projectPhpDirectoriesContents .= "        __DIR__ . '/" . $projectPhpDirectory . "'," . PHP_EOL;
        }

        $projectPhpDirectoriesContents = rtrim($projectPhpDirectoriesContents);

        return str_replace('__PATHS__', $projectPhpDirectoriesContents, $rectorPhpTemplateContents);
    }
}
