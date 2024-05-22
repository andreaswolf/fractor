<?php

declare(strict_types=1);

namespace a9f\Fractor\Console\Command;

use a9f\Fractor\Application\FractorRunner;
use a9f\Fractor\Configuration\ConfigurationFactory;
use a9f\Fractor\Configuration\Option;
use a9f\Fractor\Console\Output\SymfonyConsoleOutput;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'process', description: 'Runs Fractor with the given configuration file')]
final class ProcessCommand extends Command
{
    public function __construct(
        private readonly FractorRunner $runner,
        private readonly ConfigurationFactory $configurationFactory
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
            null,
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
        $this->runner->run(new SymfonyConsoleOutput($output), $this->configurationFactory->createFromInput($input));

        return Command::SUCCESS;
    }
}
