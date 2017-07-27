<?php

declare(strict_types=1);

namespace Linio\DynamicFormBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class CompilerPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container): void
    {
        $this->loadFormlyFields($container);
        $this->loadDataProviders($container);
        $this->loadSubscribers($container);
        $this->loadHelpMessageProviders($container);
    }

    /**
     * @param ContainerBuilder $container
     */
    public function loadFormlyFields(ContainerBuilder $container): void
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
    public function loadDataProviders(ContainerBuilder $container): void
    {
        $containerDefinition = $container->getDefinition('dynamic_form.factory');
        $taggedServices = $container->findTaggedServiceIds('dynamic_form.data_provider');

        foreach ($taggedServices as $id => $tags) {
            foreach ($tags as $attributes) {
                $containerDefinition->addMethodCall('addDataProvider', [$attributes['alias'], new Reference($id)]);
            }
        }
    }

    /**
     * @param ContainerBuilder $container
     */
    public function loadSubscribers(ContainerBuilder $container): void
    {
        $containerDefinition = $container->getDefinition('dynamic_form.factory');
        $taggedServices = $container->findTaggedServiceIds('dynamic_form.event_subscriber');

        foreach ($taggedServices as $id => $tags) {
            foreach ($tags as $attributes) {
                $containerDefinition->addMethodCall('addEventSubscriber', [$attributes['form_name'], new Reference($id)]);
            }
        }
    }

    /**
     * @param ContainerBuilder $container
     */
    public function loadHelpMessageProviders(ContainerBuilder $container): void
    {
        $containerDefinition = $container->getDefinition('dynamic_form.factory');
        $taggedServices = $container->findTaggedServiceIds('dynamic_form.help_message_provider');

        foreach ($taggedServices as $id => $tags) {
            foreach ($tags as $attributes) {
                $containerDefinition->addMethodCall('addHelpMessageProvider', [$attributes['alias'], new Reference($id)]);
            }
        }
    }
}
