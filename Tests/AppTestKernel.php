<?php

declare(strict_types=1);

namespace MarfaTech\Bundle\ApiPlatformBundle\Tests;

use MarfaTech\Bundle\ApiPlatformBundle\MarfaTechApiPlatformBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

class AppTestKernel extends Kernel
{
    public function registerBundles(): array
    {
        $bundles = array();

        if (in_array($this->getEnvironment(), array('test'))) {
            $bundles[] = new MarfaTechApiPlatformBundle();
        }

        return $bundles;
    }

    /**
     * @param LoaderInterface $loader
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/config.yaml');
        $loader->load(__DIR__ . '/../Resources/config/services.yaml');
        $loader->load(__DIR__ . '/../Resources/config/services_test.yaml');
    }

    /**
     * {@inheritdoc}
     */
    public function getCacheDir(): string
    {
        return sys_get_temp_dir() . '/MarfaTechApiPlatformBundle/cache';
    }

    /**
     * {@inheritdoc}
     */
    public function getLogDir(): string
    {
        return sys_get_temp_dir() . '/MarfaTechApiPlatformBundle/logs';
    }
}
