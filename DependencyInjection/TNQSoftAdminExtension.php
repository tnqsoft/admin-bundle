<?php

namespace TNQSoft\AdminBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class TNQSoftAdminExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $configs = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $this->remapParametersNamespaces($configs, $container, 'tnq_soft_admin');
    }

    /**
     * Adds parameters to container.
     *
     * @param array            $configs     The gloabl config of this bundle.
     * @param ContainerBuilder $container  The container for dependency injection.
     * @param string            $namespaces Config namespaces to add as parameters in the container.
     *
     * @return void
     */
    protected function remapParametersNamespaces(array $configs, ContainerBuilder $container, $namespaces)
    {
        foreach ($configs as $key => $value)
        {
            $container->setParameter($namespaces.'.'.$key, $value);
        }
    }
}
