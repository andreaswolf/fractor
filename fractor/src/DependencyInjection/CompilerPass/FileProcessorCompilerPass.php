<?php

namespace a9f\Fractor\DependencyInjection\CompilerPass;

use a9f\Fractor\Fractor\FractorRunner;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class FileProcessorCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->has(FractorRunner::class)) {
            return;
        }

        $taggedServices = $container->findTaggedServiceIds('fractor.file_processor');
        $references = array_map(static fn ($id) => new Reference($id), array_keys($taggedServices));

        $definition = $container->findDefinition(FractorRunner::class);
        $definition->setArgument('$processors', $references);
    }
}
