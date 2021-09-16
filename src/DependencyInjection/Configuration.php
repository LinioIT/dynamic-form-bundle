<?php

declare(strict_types=1);

namespace Linio\DynamicFormBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 *
 * @codeCoverageIgnore
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('dynamic_form');
        $rootNode = method_exists(TreeBuilder::class, 'getRootNode') ? $treeBuilder->getRootNode() : $treeBuilder->root('dynamic_form');

        $rootNode
            ->useAttributeAsKey('name')
            ->prototype('array')
            ->useAttributeAsKey('field')
            ->prototype('array')
            ->children()
            ->booleanNode('enabled')
            ->defaultTrue()
            ->end()
            ->scalarNode('type')
            ->isRequired()
            ->end()
            ->variableNode('options')
            ->end()
            ->variableNode('transformer')
            ->end()
            ->variableNode('validation')
            ->end()
            ->scalarNode('data_provider')
            ->end()
            ->scalarNode('help_message_provider')
            ->end()
            ->end()
            ->end()
            ->end();

        return $treeBuilder;
    }
}
