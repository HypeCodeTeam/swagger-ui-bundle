<?php declare(strict_types=1);

namespace HypeCodeTeam\SwaggerUiBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class HBSwaggerUiExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $config = $this->processConfiguration(new Configuration(), $configs);

        $container->setParameter('hct_swagger_ui.directory', $config['directory']);
        $container->setParameter('hct_swagger_ui.files', $config['files']);
        $container->setParameter('hct_swagger_ui.assetUrlPath', $config['assetUrlPath']);
        $container->setParameter('hct_swagger_ui.configFile', $config['configFile']);

        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../Resources/config')
        );
        $loader->load('services.yml');
    }
}
