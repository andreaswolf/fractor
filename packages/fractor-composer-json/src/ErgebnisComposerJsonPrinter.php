<?php

declare(strict_types=1);

namespace a9f\FractorComposerJson;

use a9f\Fractor\ValueObject\Indent;
use a9f\FractorComposerJson\Contract\ComposerJson;
use a9f\FractorComposerJson\Contract\ComposerJsonPrinter;
use Ergebnis\Json\Printer\PrinterInterface;

final class ErgebnisComposerJsonPrinter implements ComposerJsonPrinter
{
    /**
     * @readonly
     */
    private PrinterInterface $printer;

    public function __construct(PrinterInterface $printer)
    {
        $this->printer = $printer;
    }

    public function printToString(Indent $indent, ComposerJson $composerJson): string
    {
        return $this->printer->print($composerJson->toJsonString(), $indent->toString());
    }
}
