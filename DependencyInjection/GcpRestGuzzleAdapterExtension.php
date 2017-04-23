<?php

namespace GcpRestGuzzleAdapterBundle\DependencyInjection;

use GuzzleHttp\Client;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class GcpRestGuzzleAdapterExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        foreach ($config['clients'] as $key => $clientParams) {
            $definition = new Definition(Client::class);
            $definition->setFactory(['gcp_rest_guzzle_adapter.client_factory:createClient']);
            $definition->setArguments($clientParams);

            $container->setDefinition(sprintf('gcp_rest_guzzle_adapter.client.%s_client', $key), $definition);
        }
    }
}