<?php

namespace GcpRestGuzzleAdapterBundle\Tests\DependencyInjection;

use GcpRestGuzzleAdapter\Client\ClientFactory;
use GcpRestGuzzleAdapterBundle\DependencyInjection\GcpRestGuzzleAdapterExtension;
use GuzzleHttp\Client;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

class GcpRestGuzzleAdapterExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testFooClient()
    {
        $container = $this->getContainer('test.yml');

        $this->assertTrue($container->has('gcp_rest_guzzle_adapter.client_factory'));
        $this->assertTrue($container->has('gcp_rest_guzzle_adapter.client.foo_client'));

        $definition = $container->getDefinition('gcp_rest_guzzle_adapter.client.foo_client');
        $this->assertEquals([ClientFactory::class, 'createClient'], $definition->getFactory());
        $this->assertEquals(
            [
                'test@test.com',
                'foo_key',
                'foo_scope',
                'foo_project_base_url'
            ],
            $definition->getArguments()
        );
        $this->assertEquals(Client::class, $definition->getClass());
    }

    /**
     * @param $file
     * @param bool $debug
     * @return ContainerBuilder
     */
    protected function getContainer($file, $debug = false)
    {
        $container = new ContainerBuilder(new ParameterBag(array('kernel.debug' => $debug)));
        $container->registerExtension(new GcpRestGuzzleAdapterExtension());
        $locator = new FileLocator(__DIR__ . '/Fixtures');
        $loader = new YamlFileLoader($container, $locator);
        $loader->load($file);
        $container->getCompilerPassConfig()->setOptimizationPasses(array());
        $container->getCompilerPassConfig()->setRemovingPasses(array());
        $container->compile();
        return $container;
    }
}