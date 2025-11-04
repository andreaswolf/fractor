<?php

declare(strict_types=1);

namespace a9f\Fractor\ChangesReporting\Output;

use a9f\Fractor\ChangesReporting\Contract\Output\OutputFormatterInterface;
use a9f\Fractor\Configuration\ValueObject\Configuration;
use a9f\Fractor\ValueObject\ProcessResult;
use Nette\Utils\Json;

final class JsonOutputFormatter implements OutputFormatterInterface
{
    /**
     * @var string
     */
    public const NAME = 'json';

    public function getName(): string
    {
        return self::NAME;
    }

    public function report(ProcessResult $processResult, Configuration $configuration): void
    {
        $errorsJson = [
            'totals' => [
                'changed_files' => count($processResult->getFileDiffs()),
            ],
        ];

        $fileDiffs = $processResult->getFileDiffs();
        ksort($fileDiffs);
        foreach ($fileDiffs as $fileDiff) {
            $filePath = $fileDiff->getRelativeFilePath();

            $errorsJson['file_diffs'][] = [
                'file' => $filePath,
                'diff' => $fileDiff->getDiff(),
                'applied_rectors' => $fileDiff->getAppliedRules(),
            ];

            // for CI
            $errorsJson['changed_files'][] = $filePath;
        }

        $json = Json::encode($errorsJson, pretty: true);
        echo $json . PHP_EOL;
    }
}
