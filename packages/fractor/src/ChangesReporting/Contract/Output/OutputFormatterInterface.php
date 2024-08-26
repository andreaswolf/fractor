<?php

declare(strict_types=1);

namespace a9f\Fractor\ChangesReporting\Contract\Output;

use a9f\Fractor\Configuration\ValueObject\Configuration;
use a9f\Fractor\ValueObject\ProcessResult;
use Symfony\Component\Console\Style\SymfonyStyle;

interface OutputFormatterInterface
{
    public function getName(): string;

    public function report(ProcessResult $processResult, Configuration $configuration): void;

    public function setSymfonyStyle(SymfonyStyle $symfonyStyle): void;
}
