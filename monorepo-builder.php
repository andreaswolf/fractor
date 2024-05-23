<?php

declare(strict_types=1);

use a9f\FractorMonorepo\Release\FractorApplicationReleaseWriter;
use a9f\FractorMonorepo\Release\ReleaseWorker\DefineFractorApplicationReleaseVersionWorker;
use a9f\FractorMonorepo\Release\ReleaseWorker\UpdateFractorApplicationReleaseVersionWorker;
use Symplify\MonorepoBuilder\ComposerJsonManipulator\ValueObject\ComposerJsonSection;
use Symplify\MonorepoBuilder\Config\MBConfig;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\PushTagReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\SetCurrentMutualDependenciesReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\SetNextMutualDependenciesReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\TagVersionReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\UpdateBranchAliasReleaseWorker;
use Symplify\MonorepoBuilder\ValueObject\Option;

// MonoRepoBuilder uses own autoloader in custom vendor folder
require_once __DIR__ . '/vendor/autoload.php';

return static function (MBConfig $mbConfig): void {
    $mbConfig->services()
        ->set(FractorApplicationReleaseWriter::class);

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
        SetCurrentMutualDependenciesReleaseWorker::class,
        TagVersionReleaseWorker::class,
        PushTagReleaseWorker::class,
        SetNextMutualDependenciesReleaseWorker::class,
        UpdateBranchAliasReleaseWorker::class,
        UpdateFractorApplicationReleaseVersionWorker::class,
    ]);
};
