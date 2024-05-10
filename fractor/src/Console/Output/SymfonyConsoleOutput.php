<?php

declare(strict_types=1);

namespace a9f\Fractor\Console\Output;

use a9f\Fractor\Console\Contract\Output;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\OutputInterface;

final class SymfonyConsoleOutput implements Output
{
    private ?ProgressBar $progressBar = null;
    public function __construct(private readonly OutputInterface $output)
    {
    }

    public function progressStart(int $max = 0): void
    {
        $this->progressBar = new ProgressBar($this->output, $max);
        $this->progressBar->start();
    }

    public function progressAdvance(int $step = 1): void
    {
        $this->getProgressBar()->advance($step);
    }

    public function progressFinish(): void
    {
        $this->getProgressBar()->finish();
    }

    public function write(string $message): void
    {
        $this->output->writeln($message);
    }

    public function newLine(): void
    {
        $this->output->write(str_repeat(\PHP_EOL, 1));
    }

    public function listing(array $lines): void
    {
        foreach ($lines as $line) {
            $this->output->writeln($line);
        }
    }

    private function getProgressBar(): ProgressBar
    {
        return $this->progressBar ?? throw new RuntimeException('The ProgressBar is not started.');
    }
}
