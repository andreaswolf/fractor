<?php

declare(strict_types=1);

namespace a9f\Fractor\ChangesReporting\Output;

use a9f\Fractor\ChangesReporting\Contract\Output\OutputFormatterInterface;
use a9f\Fractor\Configuration\ValueObject\Configuration;
use a9f\Fractor\Differ\ValueObject\FileDiff;
use a9f\Fractor\ValueObject\ProcessResult;
use Symfony\Component\Console\Style\SymfonyStyle;

class ConsoleOutputFormatter implements OutputFormatterInterface
{
    /**
     * @var string
     */
    public const NAME = 'console';

    /**
     * @readonly
     */
    private SymfonyStyle $symfonyStyle;

    public function setSymfonyStyle(SymfonyStyle $symfonyStyle): void
    {
        $this->symfonyStyle = $symfonyStyle;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function report(ProcessResult $processResult, Configuration $configuration): void
    {
        $this->reportFileDiffs($processResult->getFileDiffs(), false);

        // to keep space between progress bar and success message
        if ($processResult->getFileDiffs() === []) {
            $this->symfonyStyle->newLine();
        }

        $message = $this->createSuccessMessage($processResult, $configuration);
        $this->symfonyStyle->success($message);
    }

    /**
     * @param FileDiff[] $fileDiffs
     */
    private function reportFileDiffs(array $fileDiffs, bool $absoluteFilePath): void
    {
        if (\count($fileDiffs) <= 0) {
            return;
        }
        // normalize
        \ksort($fileDiffs);
        $message = \sprintf('%d file%s with changes', \count($fileDiffs), \count($fileDiffs) === 1 ? '' : 's');
        $this->symfonyStyle->title($message);

        $i = 0;
        foreach ($fileDiffs as $fileDiff) {
            $filePath = $absoluteFilePath ? $fileDiff->getAbsoluteFilePath() ?? '' : $fileDiff->getRelativeFilePath();
            // append line number for faster file jump in diff
            $firstLineNumber = $fileDiff->getFirstLineNumber();
            if ($firstLineNumber !== null) {
                $filePath .= ':' . $firstLineNumber;
            }
            $message = \sprintf('<options=bold>%d) %s</>', ++$i, $filePath);
            $this->symfonyStyle->writeln($message);
            $this->symfonyStyle->newLine();
            $this->symfonyStyle->writeln($fileDiff->getDiffConsoleFormatted());

            if ($fileDiff->getAppliedRules() !== []) {
                $this->symfonyStyle->writeln('<options=underscore>Applied rules:</>');
                $this->symfonyStyle->listing($fileDiff->getAppliedRules());
                $this->symfonyStyle->newLine();
            }
        }
    }

    private function createSuccessMessage(ProcessResult $processResult, Configuration $configuration): string
    {
        $changeCount = \count($processResult->getFileDiffs());
        if ($changeCount === 0) {
            return 'Fractor is done!';
        }
        return \sprintf(
            '%d file%s %s by Fractor',
            $changeCount,
            $changeCount > 1 ? 's' : '',
            $configuration->isDryRun()
                ? 'would have been changed (dry-run)'
                : ($changeCount === 1 ? 'has' : 'have') . ' been changed'
        );
    }
}
