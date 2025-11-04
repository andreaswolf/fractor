<?php

declare(strict_types=1);

namespace a9f\Fractor\Configuration;

use a9f\Fractor\ChangesReporting\Output\ConsoleOutputFormatter;
use a9f\Fractor\Configuration\ValueObject\Configuration;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Webmozart\Assert\Assert;

final readonly class ConfigurationFactory
{
    public function __construct(
        private ContainerBagInterface $parameterBag,
        private AllowedFileExtensionsResolver $allowedFileExtensionsResolver,
        private OnlyRuleResolver $onlyRuleResolver,
        private SymfonyStyle $symfonyStyle
    ) {
    }

    public function createFromInput(InputInterface $input): Configuration
    {
        $dryRun = (bool) $input->getOption(Option::DRY_RUN);

        $outputFormat = (string) $input->getOption(Option::OUTPUT_FORMAT);
        $showProgressBar = $this->shouldShowProgressBar($input, $outputFormat);

        /** @var list<non-empty-string> $paths */
        $paths = (array) $this->parameterBag->get(Option::PATHS);

        $fileExtensions = $this->allowedFileExtensionsResolver->resolve();

        // filter rule and path
        $onlyRule = $input->getOption(Option::ONLY);
        if ($onlyRule !== null) {
            $onlyRule = $this->onlyRuleResolver->resolve($onlyRule);
        }

        return new Configuration(
            $dryRun,
            $showProgressBar,
            (bool) $input->getOption(Option::QUIET),
            $outputFormat,
            $fileExtensions,
            $paths,
            (array) $this->parameterBag->get(Option::SKIP),
            $onlyRule
        );
    }

    /**
     * @api used in tests
     * @param list<non-empty-string> $paths
     */
    public function createForTests(array $paths): Configuration
    {
        Assert::allStringNotEmpty($paths, 'No directories given');

        $fileExtensions = $this->allowedFileExtensionsResolver->resolve();

        return new Configuration(false, true, false, ConsoleOutputFormatter::NAME, $fileExtensions, $paths);
    }

    private function shouldShowProgressBar(InputInterface $input, string $outputFormat): bool
    {
        $noProgressBar = (bool) $input->getOption(Option::NO_PROGRESS_BAR);
        if ($noProgressBar) {
            return false;
        }

        if ($this->symfonyStyle->isVerbose()) {
            return false;
        }

        return $outputFormat === ConsoleOutputFormatter::NAME;
    }
}
