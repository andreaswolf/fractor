<?php

declare(strict_types=1);

namespace a9f\FractorComposerJson;

use a9f\FractorComposerJson\Contract\ComposerJson;
use a9f\FractorComposerJson\Contract\ComposerJsonFractorRule;
use a9f\FractorComposerJson\ValueObject\PackageAndVersion;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use Webmozart\Assert\Assert;

final class AddPackageToRequireComposerJsonFractorRule implements ComposerJsonFractorRule
{
    /**
     * @var PackageAndVersion[]
     */
    private array $packagesAndVersions = [];

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition('Add package to "require" in `composer.json`', [new ConfiguredCodeSample(
            <<<'CODE_SAMPLE'
{
}
CODE_SAMPLE
            ,
            <<<'CODE_SAMPLE'
{
    "require": {
        "symfony/console": "^3.4"
    }
}
CODE_SAMPLE
            ,
            [new PackageAndVersion('symfony/console', '^3.4')]
        ),
        ]);
    }

    public function refactor(ComposerJson $composerJson): void
    {
        foreach ($this->packagesAndVersions as $packageAndVersion) {
            $composerJson->addRequiredPackage($packageAndVersion);
        }
    }

    public function configure(array $configuration): void
    {
        Assert::allIsInstanceOf($configuration, PackageAndVersion::class);

        $this->packagesAndVersions = $configuration;
    }
}
