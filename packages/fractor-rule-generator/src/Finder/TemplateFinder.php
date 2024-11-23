<?php

declare(strict_types=1);

namespace a9f\FractorRuleGenerator\Finder;

use a9f\Fractor\FileSystem\FileInfoFactory;
use Symfony\Component\Finder\SplFileInfo;

final readonly class TemplateFinder
{
    /**
     * @var string
     */
    public const TEMPLATES_DIRECTORY = __DIR__ . '/../../templates';

    public function __construct(
        private FileInfoFactory $fileInfoFactory
    ) {
    }

    /**
     * @return SplFileInfo[]
     */
    public function find(string $fixtureFileExtension): array
    {
        $filePaths = $this->addRuleAndTestCase($fixtureFileExtension);

        $smartFileInfos = [];
        foreach ($filePaths as $filePath) {
            $smartFileInfos[] = $this->fileInfoFactory->createFileInfoFromPath($filePath);
        }

        return $smartFileInfos;
    }

    /**
     * @return array<int, string>
     */
    private function addRuleAndTestCase(string $fixtureFileExtension): array
    {
        return [
            __DIR__ . '/../../templates/rules/TYPO3__MajorPrefixed__/__Type__/__Name__.php',
            __DIR__ . '/../../templates/rules-tests/TYPO3__MajorPrefixed__/__Type__/__Test_Directory__/__Name__Test.php.inc',
            __DIR__ . '/../../templates/rules-tests/TYPO3__MajorPrefixed__/__Type__/__Test_Directory__/Fixtures/fixture.' . $fixtureFileExtension,
            __DIR__ . '/../../templates/rules-tests/TYPO3__MajorPrefixed__/__Type__/__Test_Directory__/config/fractor.php.inc',
        ];
    }
}
