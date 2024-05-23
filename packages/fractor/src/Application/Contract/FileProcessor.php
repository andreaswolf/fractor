<?php

declare(strict_types=1);

namespace a9f\Fractor\Application\Contract;

use a9f\Fractor\Application\ValueObject\File;

/**
 * @template T of FractorRule
 */
interface FileProcessor
{
    public function canHandle(File $file): bool;

    /**
     * @param iterable<T> $appliedRules
     */
    public function handle(File $file, iterable $appliedRules): void;

    /**
     * @return list<non-empty-string>
     */
    public function allowedFileExtensions(): array;

    /**
     * @return iterable<T>
     */
    public function getAllRules(): iterable;
}
