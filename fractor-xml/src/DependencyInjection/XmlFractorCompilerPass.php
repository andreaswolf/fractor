<?php

namespace a9f\FractorXml\DependencyInjection;

use a9f\FractorXml\XmlFileProcessor;
use a9f\FractorXml\XmlFractor;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Checks all registered classes tagged with "fractor.rule" if they are instances of {@see XmlFractor} and prepares
 * those for injection into {@see XmlFileProcessor}.
 */
final class XmlFractorCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasDefinition(XmlFileProcessor::class)) {
            return;
        }

        $taggedServices = $container->findTaggedServiceIds('fractor.rule');
        $xmlRules = array_filter(
            $taggedServices,
            static fn (string $class) => in_array(XmlFractor::class, class_implements($class) ?: []),
            ARRAY_FILTER_USE_KEY
        );
        $references = array_map(static fn ($id) => new Reference($id), array_keys($xmlRules));

        $definition = $container->findDefinition(XmlFileProcessor::class);
        $definition->setArgument('$rules', $references);
    }
}