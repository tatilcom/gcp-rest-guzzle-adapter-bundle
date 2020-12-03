<?php

namespace GcpRestGuzzleAdapterBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('gcp_rest_guzzle_adapter');

        if (method_exists($treeBuilder, 'getRootNode')) {
            $rootNode = $treeBuilder->getRootNode();
        } else {
            // symfony < 4.2 support
            $rootNode = $treeBuilder->root('gcp_rest_guzzle_adapter');
        }

        $rootNode
            ->children()
                ->arrayNode('clients')
                    ->useAttributeAsKey('key')
                    ->canBeUnset()
                    ->prototype('array')
                        ->children()
                            ->scalarNode('email')->isRequired()->cannotBeEmpty()->end()
                            ->scalarNode('private_key')->isRequired()->cannotBeEmpty()->end()
                            ->scalarNode('scope')->isRequired()->cannotBeEmpty()->end()
                            ->scalarNode('project_base_url')->isRequired()->cannotBeEmpty()->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
