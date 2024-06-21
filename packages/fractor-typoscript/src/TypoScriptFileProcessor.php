<?php

declare(strict_types=1);

namespace a9f\FractorTypoScript;

use a9f\Fractor\Application\Contract\FileProcessor;
use a9f\Fractor\Application\ValueObject\File;
use a9f\FractorTypoScript\Contract\TypoScriptFractor;
use Helmich\TypoScriptParser\Parser\Parser;
use Helmich\TypoScriptParser\Parser\Printer\PrettyPrinter;
use Helmich\TypoScriptParser\Parser\Printer\PrettyPrinterConfiguration;
use Symfony\Component\Console\Output\BufferedOutput;

/**
 * @implements FileProcessor<TypoScriptFractor>
 */
final readonly class TypoScriptFileProcessor implements FileProcessor
{
    /**
     * @param iterable<TypoScriptFractor> $rules
     */
    public function __construct(
        private iterable $rules,
        private Parser $parser,
        private PrettyPrinter $printer
    ) {
    }

    public function canHandle(File $file): bool
    {
        return in_array($file->getFileExtension(), $this->allowedFileExtensions());
    }

    public function handle(File $file, iterable $appliedRules): void
    {
        $statements = $this->parser->parseString($file->getContent());

        $statementsIterator = new TypoScriptStatementsIterator($this->rules);
        $statements = $statementsIterator->traverseDocument($file, $statements);

        $output = new BufferedOutput();
        $this->printer->setPrettyPrinterConfiguration(PrettyPrinterConfiguration::create() ->withEmptyLineBreaks());
        $this->printer->printStatements($statements, $output);
        $file->changeFileContent($output->fetch());
    }

    public function allowedFileExtensions(): array
    {
        // TODO this should be configurable
        return ['typoscript', 'tsconfig', 'ts'];
    }

    public function getAllRules(): iterable
    {
        return $this->rules;
    }
}
