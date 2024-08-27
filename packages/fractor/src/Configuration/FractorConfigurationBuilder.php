<?php

declare(strict_types=1);

namespace a9f\Fractor\Configuration;

use a9f\Fractor\Application\Contract\ConfigurableFractorRule;
use a9f\Fractor\Application\Contract\FractorRule;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Webmozart\Assert\Assert;

final class FractorConfigurationBuilder
{
    /**
     * @var string[]
     */
    private array $sets = [];

    /**
     * @var string[]
     */
    private array $paths = [];

    /**
     * @var array<mixed>
     */
    private array $skip = [];

    /**
     * @var array<class-string<FractorRule>>
     */
    private array $rules = [];

    /**
     * @var array<class-string<ConfigurableFractorRule>, array<int|string, mixed>>
     */
    private array $rulesWithConfigurations = [];

    /**
     * @var string[]
     */
    private array $imports = [];

    /**
     * @var array<string, string|int|bool>
     */
    private array $options = [];

    public function __invoke(ContainerConfigurator $containerConfigurator): void
    {
        Assert::allString($this->paths);

        $parameters = $containerConfigurator->parameters();
        $parameters->set(Option::PATHS, $this->paths);
        $parameters->set(Option::SKIP, $this->skip);

        foreach ($this->options as $optionName => $optionValue) {
            $parameters->set($optionName, $optionValue);
        }

        $services = $containerConfigurator->services();

        foreach ($this->rules as $rule) {
            Assert::classExists($rule);
            Assert::isAOf($rule, FractorRule::class);
            $services->set($rule)
                ->autoconfigure()
                ->autowire();
        }

        Assert::allString($this->sets);
        foreach ($this->sets as $set) {
            Assert::fileExists($set);
            $containerConfigurator->import($set);
        }

        foreach ($this->rulesWithConfigurations as $configuredRule => $configuration) {
            Assert::classExists($configuredRule);
            Assert::isAOf($configuredRule, ConfigurableFractorRule::class);

            // decorate with value object inliner so Symfony understands, see https://getrector.org/blog/2020/09/07/how-to-inline-value-object-in-symfony-php-config
            array_walk_recursive($configuration, function (&$value) {
                if (is_object($value)) {
                    $value = ValueObjectInliner::inline($value);
                }

                return $value;
            });

            $services->set($configuredRule)
                ->call('configure', $configuration)
                ->autoconfigure()
                ->autowire();
        }

        foreach ($this->imports as $import) {
            $containerConfigurator->import($import);
        }
    }

    /**
     * @param string[] $paths
     */
    public function withPaths(array $paths): self
    {
        $this->paths = $paths;

        return $this;
    }

    /**
     * @param array<mixed> $skip
     */
    public function withSkip(array $skip): self
    {
        $this->skip = array_merge($this->skip, $skip);

        return $this;
    }

    /**
     * @param string[] $sets
     */
    public function withSets(array $sets): self
    {
        $this->sets = array_merge($this->sets, $sets);

        return $this;
    }

    /**
     * @param class-string<ConfigurableFractorRule> $fractorClass
     * @param array<int|string, mixed> $configuration
     */
    public function withConfiguredRule(string $fractorClass, array $configuration): self
    {
        $this->rulesWithConfigurations[$fractorClass][] = $configuration;

        return $this;
    }

    /**
     * @param array<class-string<FractorRule>> $rules
     */
    public function withRules(array $rules): self
    {
        $this->rules = array_merge($this->rules, $rules);

        return $this;
    }

    public function import(string $import): self
    {
        $this->imports[] = $import;

        return $this;
    }

    /**
     * @param array<string, string|int|bool> $options
     */
    public function withOptions(array $options): self
    {
        $this->options = $options;

        return $this;
    }
}
