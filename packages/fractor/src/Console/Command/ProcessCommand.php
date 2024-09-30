<?php

declare(strict_types=1);

namespace a9f\Fractor\Console\Command;

use a9f\Fractor\Application\FractorRunner;
use a9f\Fractor\Configuration\ConfigurationFactory;
use a9f\Fractor\Configuration\Option;
use a9f\Fractor\Configuration\ValueObject\Configuration;
use a9f\Fractor\Console\ExitCode;
use a9f\Fractor\Console\Output\OutputFormatterCollector;
use a9f\Fractor\Console\Output\SymfonyConsoleOutput;
use a9f\Fractor\ValueObject\ProcessResult;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class ProcessCommand extends Command
{
    /**
     * @readonly
     */
    private FractorRunner $runner;

    /**
     * @readonly
     */
    private ConfigurationFactory $configurationFactory;

    /**
     * @readonly
     */
    private OutputFormatterCollector $outputFormatterCollector;

    public function __construct(
        FractorRunner $runner,
        ConfigurationFactory $configurationFactory,
        OutputFormatterCollector $outputFormatterCollector
    ) {
        $this->runner = $runner;
        $this->configurationFactory = $configurationFactory;
        $this->outputFormatterCollector = $outputFormatterCollector;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addOption(
            Option::CONFIG,
            Option::CONFIG_SHORT,
            InputOption::VALUE_REQUIRED,
            'The configuration file to use. Default: fractor.php in the current directory.'
        );

        $this->addOption(
            Option::DRY_RUN,
            Option::DRY_RUN_SHORT,
            InputOption::VALUE_NONE,
            'Only see the diff of changes, do not save them to files.'
        );
        $this->addOption(
            Option::QUIET,
            Option::QUIET_SHORT,
            InputOption::VALUE_NONE,
            'Do not output diff of changes.'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $configuration = $this->configurationFactory->createFromInput($input);
        $processResult = $this->runner->run(new SymfonyConsoleOutput($output), $configuration);

        $outputFormat = 'console';
        $outputFormatter = $this->outputFormatterCollector->getByName($outputFormat);
        $outputFormatter->setSymfonyStyle(new SymfonyStyle($input, $output));
        $outputFormatter->report($processResult, $configuration);

        return $this->resolveReturnCode($processResult, $configuration);
    }

    /**
     * @return ExitCode::*
     */
    private function resolveReturnCode(ProcessResult $processResult, Configuration $configuration): int
    {
        // inverse error code for CI dry-run
        if (! $configuration->isDryRun()) {
            return ExitCode::SUCCESS;
        }
        if ($processResult->getFileDiffs() !== []) {
            return ExitCode::CHANGED_CODE;
        }
        return ExitCode::SUCCESS;
    }
}
