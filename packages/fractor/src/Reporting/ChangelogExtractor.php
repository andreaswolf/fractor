<?php

declare(strict_types=1);

namespace a9f\Fractor\Reporting;

use a9f\Fractor\Application\Contract\FractorRule;
use Nette\Utils\Strings;
use Webmozart\Assert\Assert;

final class ChangelogExtractor
{
    /**
     * @param class-string<FractorRule> $ruleClassName
     */
    public function extractChangelogFromRule(string $ruleClassName): ?string
    {
        Assert::isAOf($ruleClassName, FractorRule::class);

        $reflectionClass = new \ReflectionClass($ruleClassName);

        $docComment = $reflectionClass->getDocComment();
        if (! is_string($docComment)) {
            return null;
        }

        // uses '\r?\n' instead of '$' because windows compat
        $pattern = '#' . preg_quote('changelog', '#') . '\s+(?<content>.*?)\r?\n#m';
        $matches = Strings::match($docComment, $pattern);

        return $matches['content'] ?? null;
    }
}
