<?php

declare(strict_types=1);

namespace a9f\FractorComposerJson;

use a9f\FractorComposerJson\Contract\ComposerJson;
use a9f\FractorComposerJson\Contract\ComposerJsonFractorRule;
use a9f\FractorComposerJson\ValueObject\RenamePackage;
use a9f\FractorComposerJson\ValueObject\ReplacePackageAndVersion;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use Webmozart\Assert\Assert;

final class ReplacePackageAndVersionComposerJsonFractorRule implements ComposerJsonFractorRule
{
    /**
     * @var ReplacePackageAndVersion[]
     */
    private array $replacePackagesAndVersions = [];

    public function refactor(ComposerJson $composerJson): void
    {
        foreach ($this->replacePackagesAndVersions as $replacePackageAndVersion) {
            $composerJson->replacePackage(
                $replacePackageAndVersion->getVersion(),
                new RenamePackage(
                    $replacePackageAndVersion->getOldPackageName(),
                    $replacePackageAndVersion->getNewPackageName()
                )
            );
        }
    }

    public function configure(array $configuration): void
    {
        Assert::allIsInstanceOf($configuration, ReplacePackageAndVersion::class);

        $this->replacePackagesAndVersions = $configuration;
    }

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition('Change package name and version `composer.json`', [new ConfiguredCodeSample(
            <<<'CODE_SAMPLE'
{
    "require-dev": {
        "symfony/console": "^3.4"
    }
}
CODE_SAMPLE
            ,
            <<<'CODE_SAMPLE'
{
    "require-dev": {
        "symfony/http-kernel": "^4.4"
    }
}
CODE_SAMPLE
            ,
            [new ReplacePackageAndVersion('symfony/console', 'symfony/http-kernel', '^4.4')]
        ),
        ]);
    }
}
