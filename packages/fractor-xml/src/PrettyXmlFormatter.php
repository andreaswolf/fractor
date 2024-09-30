<?php

declare(strict_types=1);

namespace a9f\FractorXml;

use a9f\Fractor\ValueObject\Indent;
use a9f\FractorXml\Contract\Formatter;

final class PrettyXmlFormatter implements Formatter
{
    /**
     * @readonly
     */
    private \PrettyXml\Formatter $prettyXmlFormatter;

    public function __construct(\PrettyXml\Formatter $prettyXmlFormatter)
    {
        $this->prettyXmlFormatter = $prettyXmlFormatter;
    }

    public function format(Indent $indent, string $content): string
    {
        $indentCharacter = $indent->isSpace() ? Indent::CHARACTERS[Indent::STYLE_SPACE] : Indent::CHARACTERS[Indent::STYLE_TAB];
        $this->prettyXmlFormatter->setIndentCharacter($indentCharacter);
        $this->prettyXmlFormatter->setIndentSize($indent->length());

        return $this->prettyXmlFormatter->format($content);
    }
}
