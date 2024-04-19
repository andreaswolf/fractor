<?php

declare(strict_types=1);

namespace a9f\FractorDocGenerator\Printer;

use Symfony\Component\Console\Style\SymfonyStyle;
use Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface;
use Symplify\RuleDocGenerator\FileSystem\ClassByTypeFinder;
use Symplify\RuleDocGenerator\RuleDefinitionsResolver;
use Symplify\RuleDocGenerator\ValueObject\RuleClassWithFilePath;

final readonly class DirectoryToMarkdownPrinter
{
    public function __construct(
        private ClassByTypeFinder       $classByTypeFinder,
        private SymfonyStyle            $symfonyStyle,
        private RuleDefinitionsResolver $ruleDefinitionsResolver,
        private RuleDefinitionsPrinter  $ruleDefinitionsPrinter,
    ) {
    }

    /**
     * @param string[] $directories
     */
    public function print(string $workingDirectory, array $directories): string
    {
        // 1. collect documented rules in provided path
        $documentedRuleClasses = $this->classByTypeFinder->findByType(
            $workingDirectory,
            $directories,
            DocumentedRuleInterface::class
        );

        $message = sprintf('Found %d documented rule classes', count($documentedRuleClasses));
        $this->symfonyStyle->note($message);

        $classes = array_map(
            static fn (RuleClassWithFilePath $ruleClassWithFilePath): string => $ruleClassWithFilePath->getClass(),
            $documentedRuleClasses
        );

        $this->symfonyStyle->listing($classes);

        // 2. create rule definition collection
        $this->symfonyStyle->note('Resolving rule definitions');

        $ruleDefinitions = $this->ruleDefinitionsResolver->resolveFromClassNames($documentedRuleClasses);

        // 3. print rule definitions to markdown lines
        $this->symfonyStyle->note('Printing rule definitions');
        $markdownLines = $this->ruleDefinitionsPrinter->print($ruleDefinitions);

        $fileContent = '';
        foreach ($markdownLines as $markdownLine) {
            $fileContent .= trim($markdownLine) . PHP_EOL . PHP_EOL;
        }

        return rtrim($fileContent) . PHP_EOL;
    }
}
