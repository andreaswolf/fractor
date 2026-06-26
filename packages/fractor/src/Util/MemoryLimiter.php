<?php

declare(strict_types=1);

namespace a9f\Fractor\Util;

use a9f\Fractor\Configuration\ValueObject\Configuration;
use a9f\Fractor\Exception\Configuration\InvalidConfigurationException;
use Nette\Utils\Strings;

final class MemoryLimiter
{
    /**
     * @see https://regex101.com/r/pmiGUM/1
     */
    private const VALID_MEMORY_LIMIT_REGEX = '#^-?\d+[kMG]?$#i';

    public function adjust(Configuration $configuration): void
    {
        $memoryLimit = $configuration->getMemoryLimit();
        if ($memoryLimit === null) {
            return;
        }

        $this->validateMemoryLimitFormat($memoryLimit);

        $memorySetResult = ini_set('memory_limit', $memoryLimit);

        if ($memorySetResult === false) {
            $errorMessage = sprintf('Memory limit "%s" cannot be set.', $memoryLimit);
            throw new InvalidConfigurationException($errorMessage);
        }
    }

    private function validateMemoryLimitFormat(string $memoryLimit): void
    {
        $memoryLimitFormatMatch = Strings::match($memoryLimit, self::VALID_MEMORY_LIMIT_REGEX);
        if ($memoryLimitFormatMatch !== null) {
            return;
        }

        $errorMessage = sprintf('Invalid memory limit format "%s".', $memoryLimit);
        throw new InvalidConfigurationException($errorMessage);
    }
}
