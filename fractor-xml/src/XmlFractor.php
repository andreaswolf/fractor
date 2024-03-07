<?php

namespace a9f\FractorXml;

interface XmlFractor
{
    public function canHandle(\DOMNode $node): bool;

    public function refactor(\DOMNode $node): \DOMNode|int|null;
}