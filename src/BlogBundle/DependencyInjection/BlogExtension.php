<?php

declare(strict_types=1);

namespace BlogBundle\DependencyInjection;

use Exception;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Расширение блога
 */
class BlogExtension extends Extension
{
    /**
     * Выполняет загрузку расширения
     *
     * @param array            $configs
     * @param ContainerBuilder $container
     *
     * @return void
     *
     * @throws Exception
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );

        $loader->load('services.yml');
    }
}
