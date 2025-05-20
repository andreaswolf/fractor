<?php

declare(strict_types=1);

namespace a9f\Fractor\Console\Command;

use a9f\Fractor\Application\FractorRunner;
use a9f\Fractor\Caching\Detector\ChangedFilesDetector;
use a9f\Fractor\Configuration\ConfigurationFactory;
use a9f\Fractor\Configuration\Option;
use a9f\Fractor\Configuration\ValueObject\Configuration;
use a9f\Fractor\Console\Application\FractorApplication;
use a9f\Fractor\Console\ExitCode;
use a9f\Fractor\Console\Output\OutputFormatterCollector;
use a9f\Fractor\Console\Output\SymfonyConsoleOutput;
use a9f\Fractor\Exception\ShouldNotHappenException;
use a9f\Fractor\ValueObject\ProcessResult;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'process', description: 'Runs Fractor with the given configuration file')]
final class ProcessCommand extends Command
{
    public function __construct(
        private readonly FractorRunner $runner,
        private readonly ConfigurationFactory $configurationFactory,
        private readonly OutputFormatterCollector $outputFormatterCollector,
        private readonly ChangedFilesDetector $changedFilesDetector
    ) {
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
        $this->addOption(Option::CLEAR_CACHE, null, InputOption::VALUE_NONE, 'Clear unchanged files cache');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $configuration = $this->configurationFactory->createFromInput($input);

        if ($configuration->getConfigurationFile() === null) {
            $io->error('No configuration file specified, cannot run Fractor.');
            return Command::FAILURE;
        }

        $processResult = $this->runner->run(new SymfonyConsoleOutput($output), $configuration);

        $outputFormat = 'console';
        $outputFormatter = $this->outputFormatterCollector->getByName($outputFormat);
        $outputFormatter->setSymfonyStyle($io);
        $outputFormatter->report($processResult, $configuration);

        return $this->resolveReturnCode($processResult, $configuration);
    }

    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        $application = $this->getApplication();
        if (! $application instanceof FractorApplication) {
            throw new ShouldNotHappenException();
        }
        // clear cache
        $optionClearCache = (bool) $input->getOption(Option::CLEAR_CACHE);
        if ($optionClearCache) {
            $this->changedFilesDetector->clear();
        }
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
