<?php

declare(strict_types=1);

namespace a9f\Fractor\Configuration;

use a9f\Fractor\Application\Contract\FractorRule;
use a9f\Fractor\Exception\Configuration\FractorRuleNameAmbiguousException;
use a9f\Fractor\Exception\Configuration\FractorRuleNotFoundException;
use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;

final readonly class OnlyRuleResolver
{
    /**
     * @var FractorRule[]
     */
    private array $fractors;

    /**
     * @param RewindableGenerator<FractorRule> $fractors
     */
    public function __construct(iterable $fractors)
    {
        $this->fractors = iterator_to_array($fractors->getIterator());
    }

    public function resolve(string $rule): string
    {
        // fix wrongly double escaped backslashes
        $rule = str_replace('\\\\', '\\', $rule);

        // remove single quotes appearing when single-quoting arguments on windows
        if (str_starts_with($rule, "'") && str_ends_with($rule, "'")) {
            $rule = substr($rule, 1, -1);
        }

        $rule = ltrim($rule, '\\');

        foreach ($this->fractors as $fractor) {
            if ($fractor::class === $rule) {
                return $rule;
            }
        }

        // allow short rule names if there are not duplicates
        $matching = [];
        foreach ($this->fractors as $fractor) {
            if (str_ends_with($fractor::class, '\\' . $rule)) {
                $matching[] = $fractor::class;
            }
        }

        /** @var string[] $matching */
        $matching = array_unique($matching);
        if (count($matching) === 1) {
            return $matching[0];
        }

        if (count($matching) > 1) {
            sort($matching);
            $message = sprintf(
                'Short rule name "%s" is ambiguous. Specify the full rule name:' . PHP_EOL
                . '- ' . implode(PHP_EOL . '- ', $matching),
                $rule
            );
            throw new FractorRuleNameAmbiguousException($message);
        }

        if (! str_contains($rule, '\\')) {
            $message = sprintf(
                'Rule "%s" was not found.%sThe rule has no namespace. Make sure to escape the backslashes, and add quotes around the rule name: --only="My\\Fractor\\Rule"',
                $rule,
                PHP_EOL
            );
        } else {
            $message = sprintf(
                'Rule "%s" was not found.%sMake sure it is registered in your config or in one of the sets',
                $rule,
                PHP_EOL
            );
        }

        throw new FractorRuleNotFoundException($message);
    }
}
