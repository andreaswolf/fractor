<?php

declare(strict_types=1);

namespace a9f\FractorRuleGenerator\FileSystem;

use a9f\Fractor\Exception\ShouldNotHappenException;
use a9f\FractorRuleGenerator\Factory\TemplateFactory;
use Nette\Utils\Strings;
use Symfony\Component\Filesystem\Filesystem;

final readonly class ConfigFilesystemWriter
{
    /**
     * @var string[]
     */
    private const REQUIRED_KEYS = ['__MajorPrefixed__', '__Type__', '__Name__'];

    /**
     * @see https://regex101.com/r/gJ0bHJ/1
     * @var string
     */
    private const LAST_ITEM_REGEX = '#;\n};#';

    public function __construct(
        private Filesystem $filesystem,
        private TemplateFactory $templateFactory
    ) {
    }

    /**
     * @param array<string, string> $templateVariables
     */
    public function addRuleToConfigurationFile(
        string $configFilePath,
        array $templateVariables,
        string $rectorFqnNamePattern
    ): void {
        $this->createConfigurationFileIfNotExists($configFilePath);

        $configFileContents = (string) file_get_contents($configFilePath);

        $this->ensureRequiredKeysAreSet($templateVariables);

        // already added?
        $servicesFullyQualifiedName = $this->templateFactory->create($rectorFqnNamePattern, $templateVariables);
        if (\str_contains($configFileContents, $servicesFullyQualifiedName)) {
            return;
        }

        $rule = sprintf('$services->set(\\%s::class);', $servicesFullyQualifiedName);
        // Add new rule to existing ones or add as first rule of new configuration file.
        if (Strings::match($configFileContents, self::LAST_ITEM_REGEX) !== null
            && Strings::match($configFileContents, self::LAST_ITEM_REGEX) !== []
        ) {
            $registerServiceLine = sprintf(';' . PHP_EOL . '    %s' . PHP_EOL . '};', $rule);
            $configFileContents = Strings::replace($configFileContents, self::LAST_ITEM_REGEX, $registerServiceLine);
        } else {
            $configFileContents = str_replace('###FIRST_RULE###', $rule, $configFileContents);
        }

        // Print the content back to file
        $this->filesystem->dumpFile($configFilePath, $configFileContents);
    }

    /**
     * @param array<string, string> $templateVariables
     */
    private function ensureRequiredKeysAreSet(array $templateVariables): void
    {
        $missingKeys = array_diff(self::REQUIRED_KEYS, array_keys($templateVariables));
        if ($missingKeys === []) {
            return;
        }

        $message = sprintf('Template variables for "%s" keys are missing', implode('", "', $missingKeys));
        throw new ShouldNotHappenException($message);
    }

    private function createConfigurationFileIfNotExists(string $configFilePath): void
    {
        if ($this->filesystem->exists($configFilePath)) {
            return;
        }

        $parentDirectory = dirname($configFilePath);
        $this->filesystem->mkdir($parentDirectory);
        $this->filesystem->touch($configFilePath);
        $this->filesystem->appendToFile(
            $configFilePath,
            (string) file_get_contents(__DIR__ . '/../../templates/config/config.php'),
            true
        );
    }
}
