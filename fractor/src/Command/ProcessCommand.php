<?php

namespace a9f\Fractor\Command;

use a9f\Fractor\Fractor\FileProcessor;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand('process', 'Runs Fractor with the given configuration file')]
class ProcessCommand extends Command
{
    /**
     * @param iterable<FileProcessor> $processors
     */
    public function __construct(private readonly iterable $processors)
    {
        parent::__construct();
    }

    protected function configure()
    {
        parent::configure();

        $this->addArgument('config', InputArgument::OPTIONAL, 'The configuration file to use. Default: fractor.php in the current directory.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $configurationFile = $input->getArgument('config') ?? getcwd() . '/fractor.php';

        $output->writeln($configurationFile);

        return 0;
    }
}
