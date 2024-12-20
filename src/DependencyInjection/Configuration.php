<?php declare(strict_types=1);

namespace HypeCodeTeam\SwaggerUiBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('hct_swagger_ui');
        if (\method_exists($treeBuilder, 'getRootNode')) {
            $rootNode = $treeBuilder->getRootNode();
        } else {
            // BC layer for symfony/config 4.1 and older
            $rootNode = $treeBuilder->root('hct_swagger_ui');
        }

        $rootNode
            ->children()
            ->scalarNode('directory')->defaultValue('')->end()
            ->scalarNode('assetUrlPath')->defaultValue('/bundles/hctswaggerui/')->end()
            ->scalarNode('configFile')->defaultNull()->end()
            ->arrayNode('files')->isRequired()->prototype('scalar')->end()
            ->end();

        return $treeBuilder;
    }
}
