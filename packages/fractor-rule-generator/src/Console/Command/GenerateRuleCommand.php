<?php

declare(strict_types=1);

namespace a9f\FractorRuleGenerator\Console\Command;

use a9f\Fractor\Exception\ShouldNotHappenException;
use a9f\Fractor\FileSystem\FileInfoFactory;
use a9f\FractorRuleGenerator\Factory\Typo3FractorTypeFactory;
use a9f\FractorRuleGenerator\FileSystem\ConfigFilesystemWriter;
use a9f\FractorRuleGenerator\Finder\TemplateFinder;
use a9f\FractorRuleGenerator\Generator\FileGenerator;
use a9f\FractorRuleGenerator\ValueObject\Typo3FractorRecipe;
use a9f\FractorRuleGenerator\ValueObject\Typo3Version;
use RuntimeException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;
use Webmozart\Assert\Assert;

#[AsCommand(name: 'generate-rule', description: 'Generate a new Fractor rule in a proper location, with tests')]
final class GenerateRuleCommand extends Command
{
    /**
     * @var string
     */
    private const FRACTOR_FQN_NAME_PATTERN = 'a9f\Typo3Fractor\TYPO3__MajorPrefixed__\__Type__\__Name__';

    public function __construct(
        private readonly TemplateFinder $templateFinder,
        private readonly FileGenerator $fileGenerator,
        private readonly OutputInterface $outputStyle,
        private readonly ConfigFilesystemWriter $configFilesystemWriter,
        private readonly FileInfoFactory $fileInfoFactory
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var QuestionHelper $helper */
        $helper = $this->getHelper('question');

        /** @var Typo3Version $typo3Version */
        $typo3Version = $helper->ask($input, $output, $this->askForTypo3Version());
        $changelogUrl = $helper->ask($input, $output, $this->askForChangelogUrl());
        $name = $helper->ask($input, $output, $this->askForName());
        $description = $helper->ask($input, $output, $this->askForDescription());
        $type = $helper->ask($input, $output, $this->askForType());

        $recipe = new Typo3FractorRecipe(
            $typo3Version,
            $changelogUrl,
            $name,
            $description,
            Typo3FractorTypeFactory::fromString($type)
        );

        $templateFileInfos = $this->templateFinder->find($recipe->getFractorFixtureFileExtension());

        $templateVariables = [
            '__MajorPrefixed__' => $recipe->getMajorVersionPrefixed(),
            '__Major__' => $recipe->getMajorVersion(),
            '__MinorPrefixed__' => $recipe->getMinorVersionPrefixed(),
            '__Type__' => $recipe->getFractorTypeFolderName(),
            '__FixtureFileExtension__' => $recipe->getFractorFixtureFileExtension(),
            '__Name__' => $recipe->getFractorName(),
            '__Test_Directory__' => $recipe->getTestDirectory(),
            '__Changelog_Annotation__' => $recipe->getChangelogAnnotation(),
            '__Description__' => addslashes($recipe->getDescription()),
            '__Use__' => $recipe->getUseImports(),
            '__Traits__' => $recipe->getTraits(),
            '__ExtendsImplements__' => $recipe->getExtendsImplements(),
            '__Base_Fractor_Body_Template__' => $recipe->getFractorBodyTemplate(),
        ];

        $targetDirectory = __DIR__ . '/../../../../typo3-fractor';

        $generatedFilePaths = $this->fileGenerator->generateFiles(
            $templateFileInfos,
            $templateVariables,
            $targetDirectory
        );

        $this->configFilesystemWriter->addRuleToConfigurationFile(
            $recipe->getSet(),
            $templateVariables,
            self::FRACTOR_FQN_NAME_PATTERN
        );

        $testCaseDirectoryPath = $this->resolveTestCaseDirectoryPath($generatedFilePaths);
        $this->printSuccess($recipe->getFractorName(), $generatedFilePaths, $testCaseDirectoryPath);

        return Command::SUCCESS;
    }

    private function askForTypo3Version(): Question
    {
        $whatTypo3Version = new Question('TYPO3-Version (e.g. 12.0): ');
        $whatTypo3Version->setNormalizer(
            static fn ($version): Typo3Version => Typo3Version::createFromString(trim((string) $version))
        );
        $whatTypo3Version->setMaxAttempts(2);
        $whatTypo3Version->setValidator(
            static function (Typo3Version $version): Typo3Version {
                Assert::greaterThanEq($version->getMajor(), 7);
                Assert::greaterThanEq($version->getMinor(), 0);

                return $version;
            }
        );

        return $whatTypo3Version;
    }

    private function askForChangelogUrl(): Question
    {
        $whatIsTheUrlToChangelog = new Question(
            'URL to changelog (e.g. https://docs.typo3.org/c/typo3/cms-core/main/en-us/Changelog/...) or "x" for none: '
        );
        $whatIsTheUrlToChangelog->setMaxAttempts(3);
        $whatIsTheUrlToChangelog->setValidator(
            static function (?string $url): string {
                Assert::notNull($url);

                if (strtolower($url) === 'x') {
                    return '';
                }

                if (! filter_var($url, FILTER_VALIDATE_URL)) {
                    throw new RuntimeException('Please enter a valid Url');
                }

                Assert::startsWith($url, 'https://docs.typo3.org/c/typo3/cms-core/main/en-us/Changelog/');

                return $url;
            }
        );

        return $whatIsTheUrlToChangelog;
    }

    private function askForName(): Question
    {
        $giveMeYourName = new Question('Name (e.g. MigrateRequiredFlag; must be a valid PHP class name): ');
        $giveMeYourName->setNormalizer(
            static fn ($name): ?string => preg_replace('/Fractor$/', '', ucfirst((string) $name))
        );
        $giveMeYourName->setMaxAttempts(3);
        $giveMeYourName->setValidator(static function (string $name): string {
            Assert::minLength($name, 5);
            Assert::maxLength($name, 60);
            Assert::notContains($name, ' ', 'The name must not contain spaces');
            // Pattern from: https://www.php.net/manual/en/language.oop5.basic.php
            Assert::regex(
                $name,
                '/^[a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*$/',
                'The name must be a valid PHP class name. A valid class name starts with a letter or underscore, followed by any number of letters, numbers, or underscores.'
            );

            return $name;
        });

        return $giveMeYourName;
    }

    private function askForDescription(): Question
    {
        $description = new Question('Description (e.g. Migrate required flag): ');
        $description->setMaxAttempts(3);
        $description->setValidator(static function (?string $description): string {
            Assert::notNull($description, 'Please enter a description');
            Assert::minLength($description, 5);
            Assert::maxLength($description, 120);

            return $description;
        });

        return $description;
    }

    private function askForType(): ChoiceQuestion
    {
        $question = new ChoiceQuestion('Please select the Fractor type', [
            'flexform',
            'fluid',
            'typoscript',
            'yaml',
            'composer',
            'htaccess',
        ]);
        $question->setMaxAttempts(3);
        $question->setErrorMessage('Type %s is invalid.');

        return $question;
    }

    /**
     * @param string[] $generatedFilePaths
     */
    private function printSuccess(string $name, array $generatedFilePaths, string $testCaseFilePath): void
    {
        $message = sprintf('<info>New files generated for "%s":</info>', $name);
        $this->outputStyle->writeln($message);

        sort($generatedFilePaths);

        foreach ($generatedFilePaths as $generatedFilePath) {
            $fileInfo = $this->fileInfoFactory->createFileInfoFromPath($generatedFilePath);
            $this->outputStyle->writeln(' * ' . $fileInfo->getRelativePathname());
        }

        $message = sprintf(
            '<info>Run tests for this fractor:</info>%svendor/bin/phpunit %s',
            PHP_EOL . PHP_EOL,
            $testCaseFilePath . PHP_EOL
        );
        $this->outputStyle->writeln($message);
    }

    /**
     * @param string[] $generatedFilePaths
     */
    private function resolveTestCaseDirectoryPath(array $generatedFilePaths): string
    {
        foreach ($generatedFilePaths as $generatedFilePath) {
            if (! \str_ends_with($generatedFilePath, 'Test.php')
                && ! \str_ends_with($generatedFilePath, 'Test.php.inc')
            ) {
                continue;
            }

            $generatedFileInfo = $this->fileInfoFactory->createFileInfoFromPath($generatedFilePath);
            return $generatedFileInfo->getRelativePath();
        }

        throw new ShouldNotHappenException();
    }
}
