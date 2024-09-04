<?php

declare(strict_types=1);

namespace a9f\FractorRuleGenerator\Generator;

use a9f\FractorRuleGenerator\Factory\TemplateFactory;
use a9f\FractorRuleGenerator\FileSystem\TemplateFileSystem;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\SplFileInfo;

final readonly class FileGenerator
{
    public function __construct(
        private Filesystem $filesystem,
        private TemplateFactory $templateFactory,
        private TemplateFileSystem $templateFileSystem
    ) {
    }

    /**
     * @param SplFileInfo[] $templateFileInfos
     * @param string[] $templateVariables
     * @return string[]
     */
    public function generateFiles(
        array $templateFileInfos,
        array $templateVariables,
        string $destinationDirectory
    ): array {
        $generatedFilePaths = [];

        foreach ($templateFileInfos as $fileInfo) {
            $generatedFilePaths[] = $this->generateFileInfoWithTemplateVariables(
                $fileInfo,
                $templateVariables,
                $destinationDirectory
            );
        }

        return $generatedFilePaths;
    }

    /**
     * @param array<string, mixed> $templateVariables
     */
    private function generateFileInfoWithTemplateVariables(
        SplFileInfo $smartFileInfo,
        array $templateVariables,
        string $targetDirectory
    ): string {
        $targetFilePath = $this->templateFileSystem->resolveDestination(
            $smartFileInfo,
            $templateVariables,
            $targetDirectory
        );

        $content = $this->templateFactory->create($smartFileInfo->getContents(), $templateVariables);

        $this->filesystem->dumpFile($targetFilePath, $content);

        return $targetFilePath;
    }
}
