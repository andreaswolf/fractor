<?php

declare(strict_types=1);

use a9f\FractorMonorepo\Release\FractorApplicationReleaseWriter;
use a9f\FractorMonorepo\Release\FractorInitReleaseWriter;
use a9f\FractorMonorepo\Release\FractorInitTestReleaseWriter;
use a9f\FractorMonorepo\Release\ReleaseWorker\DefineFractorApplicationReleaseVersionWorker;
use a9f\FractorMonorepo\Release\ReleaseWorker\DefineFractorInitReleaseVersionWorker;
use a9f\FractorMonorepo\Release\ReleaseWorker\DefineFractorInitTestReleaseVersionWorker;
use Symplify\MonorepoBuilder\ComposerJsonManipulator\ValueObject\ComposerJsonSection;
use Symplify\MonorepoBuilder\Config\MBConfig;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\PushTagReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\SetCurrentMutualDependenciesReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\TagVersionReleaseWorker;
use Symplify\MonorepoBuilder\ValueObject\Option;

require_once __DIR__ . '/vendor/autoload.php';

return static function (MBConfig $mbConfig): void {
    $mbConfig->services()
        ->set(FractorApplicationReleaseWriter::class)
        ->set(FractorInitReleaseWriter::class)
        ->set(FractorInitTestReleaseWriter::class);

    $mbConfig->packageDirectories([__DIR__ . '/packages']);
    $mbConfig->defaultBranch('main');
    $mbConfig->dataToRemove([
        ComposerJsonSection::REPOSITORIES => [
            // this will remove all repositories
            Option::REMOVE_COMPLETELY,
        ],
        'minimum-stability' => 'dev',
        'prefer-stable' => true,
    ]);
    // release workers - in order of execution
    $mbConfig->workers([
        DefineFractorApplicationReleaseVersionWorker::class,
        DefineFractorInitReleaseVersionWorker::class,
        DefineFractorInitTestReleaseVersionWorker::class,
        SetCurrentMutualDependenciesReleaseWorker::class,
        TagVersionReleaseWorker::class,
        PushTagReleaseWorker::class,
        // we don't raise the dependency versions and branch alias here b/c of a bug in symplify/monorepo-builder,
        // see docs/release.md and https://github.com/symplify/monorepo-builder/issues/77 for more information
    ]);
};
