<?php

namespace Linio\DynamicFormBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Linio\DynamicFormBundle\DataProvider;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 * @codeCoverageIgnore
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('dynamic_form');

        $rootNode
            ->useAttributeAsKey('name')
            ->prototype('array')
                ->useAttributeAsKey('field')
                ->prototype('array')
                    ->children()
                        ->booleanNode('enabled')
                            ->defaultFalse()
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
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
