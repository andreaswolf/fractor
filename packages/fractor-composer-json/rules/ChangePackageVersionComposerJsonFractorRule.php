<?php
declare(strict_types=1);

namespace a9f\FractorComposerJson;

use a9f\FractorComposerJson\Contract\ComposerJson;
use a9f\FractorComposerJson\Contract\ComposerJsonFractorRule;
use a9f\FractorComposerJson\ValueObject\PackageAndVersion;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use Webmozart\Assert\Assert;

final class ChangePackageVersionComposerJsonFractorRule implements ComposerJsonFractorRule
{
    /**
     * @var PackageAndVersion[]
     */
    private array $packagesAndVersions = [];

    public function refactor(ComposerJson $composerJson): void
    {
        foreach ($this->packagesAndVersions as $packageAndVersion) {
            $composerJson->changePackageVersion($packageAndVersion);
        }
    }

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition('Change package version `composer.json`', [new ConfiguredCodeSample(
            <<<'CODE_SAMPLE'
{
    "require": {
        "symfony/console": "^3.4"
    }
}
CODE_SAMPLE
            ,
            <<<'CODE_SAMPLE'
{
    "require": {
        "symfony/console": "^4.4"
    }
}
CODE_SAMPLE
            ,
            [new PackageAndVersion('symfony/console', '^4.4')]
        ),
        ]);
    }

    public function configure(array $configuration): void
    {
        Assert::allIsAOf($configuration, PackageAndVersion::class);

        $this->packagesAndVersions = $configuration;
    }
}