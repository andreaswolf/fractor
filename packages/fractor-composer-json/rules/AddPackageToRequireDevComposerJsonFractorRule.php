<?php

declare(strict_types=1);

namespace a9f\FractorComposerJson;

use a9f\Fractor\Contract\NoChangelogRequired;
use a9f\FractorComposerJson\Contract\ComposerJson;
use a9f\FractorComposerJson\Contract\ComposerJsonFractorRule;
use a9f\FractorComposerJson\ValueObject\PackageAndVersion;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use Webmozart\Assert\Assert;

final class AddPackageToRequireDevComposerJsonFractorRule implements ComposerJsonFractorRule, NoChangelogRequired
{
    /**
     * @var PackageAndVersion[]
     */
    private array $packageAndVersions = [];

    public function refactor(ComposerJson $composerJson): void
    {
        foreach ($this->packageAndVersions as $packageAndVersion) {
            $composerJson->addRequiredDevPackage($packageAndVersion);
        }
    }

    public function configure(array $configuration): void
    {
        Assert::allIsInstanceOf($configuration, PackageAndVersion::class);

        $this->packageAndVersions = $configuration;
    }

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition('Add package to "require-dev" in `composer.json`', [new ConfiguredCodeSample(
            <<<'CODE_SAMPLE'
{
}
CODE_SAMPLE
            ,
            <<<'CODE_SAMPLE'
{
    "require-dev": {
        "symfony/console": "^3.4"
    }
}
CODE_SAMPLE
            ,
            [new PackageAndVersion('symfony/console', '^3.4')]
        ),
        ]);
    }
}
