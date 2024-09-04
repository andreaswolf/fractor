<?php

declare(strict_types=1);

namespace a9f\FractorRuleGenerator\Factory;

final class TemplateFactory
{
    /**
     * @param array<string, string> $variables
     */
    public function create(string $content, array $variables): string
    {
        $variableKeys = array_keys($variables);
        $variableValues = array_values($variables);

        return str_replace($variableKeys, $variableValues, $content);
    }
}
