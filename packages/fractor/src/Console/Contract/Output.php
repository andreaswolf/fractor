<?php

declare(strict_types=1);

namespace a9f\Fractor\Console\Contract;

interface Output
{
    public function progressStart(int $max = 0): void;

    /**
     * Advances the progress output X steps.
     */
    public function progressAdvance(int $step = 1): void;

    /**
     * Finishes the progress output.
     */
    public function progressFinish(): void;

    public function write(string $message): void;

    public function newLine(): void;

    /**
     * @param string[] $lines
     */
    public function listing(array $lines): void;
}
