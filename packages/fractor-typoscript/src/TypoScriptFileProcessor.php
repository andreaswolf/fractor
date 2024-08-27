<?php

declare(strict_types=1);

namespace a9f\FractorTypoScript;

use a9f\Fractor\Application\Contract\FileProcessor;
use a9f\Fractor\Application\ValueObject\File;
use a9f\FractorTypoScript\Contract\TypoScriptFractor;
use a9f\FractorTypoScript\Factory\PrettyPrinterConfigurationFactory;
use a9f\FractorTypoScript\ValueObject\TypoScriptPrettyPrinterFormatConfiguration;
use Helmich\TypoScriptParser\Parser\ParseError;
use Helmich\TypoScriptParser\Parser\Parser;
use Helmich\TypoScriptParser\Parser\Printer\PrettyPrinter;
use Helmich\TypoScriptParser\Tokenizer\TokenizerException;
use Symfony\Component\Console\Output\BufferedOutput;

/**
 * @implements FileProcessor<TypoScriptFractor>
 */
final readonly class TypoScriptFileProcessor implements FileProcessor
{
    private BufferedOutput $output;

    /**
     * @param iterable<TypoScriptFractor> $rules
     */
    public function __construct(
        private iterable $rules,
        private Parser $parser,
        private PrettyPrinter $printer,
        private PrettyPrinterConfigurationFactory $prettyPrinterConfigurationFactory,
        private TypoScriptPrettyPrinterFormatConfiguration $typoScriptPrettyPrinterFormatConfiguration
    ) {
        $this->output = new BufferedOutput();
    }

    public function canHandle(File $file): bool
    {
        return in_array($file->getFileExtension(), $this->allowedFileExtensions());
    }

    public function handle(File $file, iterable $appliedRules): void
    {
        try {
            $statements = $this->parser->parseString($file->getContent());

            $statementsIterator = new TypoScriptStatementsIterator($this->rules);
            $statements = $statementsIterator->traverseDocument($file, $statements);

            $this->printer->setPrettyPrinterConfiguration(
                $this->prettyPrinterConfigurationFactory->createPrettyPrinterConfiguration(
                    $file,
                    $this->typoScriptPrettyPrinterFormatConfiguration
                )
            );
            $this->printer->printStatements($statements, $this->output);

            $newTypoScriptContent = $this->output->fetch();
            $typoScriptContent = rtrim($newTypoScriptContent) . "\n";
            $file->changeFileContent($typoScriptContent);
        } catch (TokenizerException) {
            return;
        } catch (ParseError) {
        }
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
