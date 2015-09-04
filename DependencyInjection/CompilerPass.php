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
        $this->loadFormlyFields($container);
        $this->loadDataProviders($container);

    }

    /**
     * @param ContainerBuilder $container
     */
    public function loadFormlyFields(ContainerBuilder $container)
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

    /**
     * @param ContainerBuilder $container
     */
    public function loadDataProviders(ContainerBuilder $container)
    {
        $containerDefinition = $container->getDefinition('dynamic_form.factory');
        $taggedServices = $container->findTaggedServiceIds('dynamic_form.data_provider');

        foreach ($taggedServices as $id => $tags) {
            foreach ($tags as $attributes) {
                $containerDefinition->addMethodCall('addDataProvider', [$attributes['alias'], new Reference($id)]);
            }
        }
    }
}
