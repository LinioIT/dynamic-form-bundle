<?php

namespace Linio\DynamicFormBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class CompilerPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('container.formly_field')) {
            return;
        }

        $containerDefinition = $container->getDefinition('container.formly_field');
        $taggedServices = $container->findTaggedServiceIds('formly_field');

        foreach ($taggedServices as $id => $tags) {
            foreach ($tags as $attributes) {
                $containerDefinition->addMethodCall('addFormlyField', [$attributes['alias'], new Reference($id)]);
            }
        }
    }
}
