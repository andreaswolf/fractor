<?php
declare(strict_types=1);

namespace a9f\FractorComposerJson;

use a9f\FractorComposerJson\Contract\ComposerJson;
use a9f\FractorComposerJson\Contract\ComposerJsonFractorRule;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use Webmozart\Assert\Assert;

final class RemovePackageComposerJsonFractorRule implements ComposerJsonFractorRule
{
    /**
     * @var string[]
     */
    private array $packageNames = [];

    public function refactor(ComposerJson $composerJson): void
    {
        foreach ($this->packageNames as $packageName) {
            $composerJson->removePackage($packageName);
        }
    }

    public function configure(array $configuration): void
    {
        Assert::allString($configuration);

        $this->packageNames = $configuration;
    }

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition('Remove package from "require" and "require-dev" in `composer.json`', [
            new ConfiguredCodeSample(
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
}
CODE_SAMPLE
                ,
                ['symfony/console']
            ),
        ]);
    }
}