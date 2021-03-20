<?php

namespace Cravler\Print2PdfBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('cravler_print2pdf');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->scalarNode('binary')
                    ->defaultValue('print2pdf')
                ->end()
                ->append($this->getOptionsNode('default_options'))
                ->scalarNode('temporary_folder')
                    ->defaultValue(null)
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }

    /**
     * @param string $name
     * @return ArrayNodeDefinition
     */
    public function getOptionsNode(string $name): ArrayNodeDefinition
    {
        $treeBuilder = new TreeBuilder($name);
        $node = $treeBuilder->getRootNode();

        $node
            ->addDefaultsIfNotSet()
            ->children()
                ->integerNode('timeout')
                    ->info('Process timeout in seconds')
                ->end()
                ->booleanNode('landscape')
                    ->info('Landscape paper orientation')
                ->end()
                ->booleanNode('print_background')
                    ->info('Print background graphics')
                ->end()
                ->floatNode('scale')
                    ->info('Scale of the webpage rendering')
                ->end()
                ->floatNode('paper_width')
                    ->info('Paper width in inches')
                ->end()
                ->floatNode('paper_height')
                    ->info('Paper height in inches')
                ->end()
                ->floatNode('margin_top')
                    ->info('Top margin in inches')
                ->end()
                ->floatNode('margin_bottom')
                    ->info('Bottom margin in inches')
                ->end()
                ->floatNode('margin_left')
                    ->info('Left margin in inches')
                ->end()
                ->floatNode('margin_right')
                    ->info('Right margin in inches')
                ->end()
                ->booleanNode('prefer_css_page_size')
                    ->info('Prefer page size defined by CSS')
                ->end()
                ->scalarNode('page_ranges')
                    ->info('Paper ranges to print, e.g., "1-5, 8, 11-13"')
                ->end()
                ->booleanNode('ignore_invalid_page_ranges')
                    ->info('Silently ignore invalid but successfully parsed page ranges, such as "3-2"')
                ->end()
                ->scalarNode('header_template')
                    ->info('HTML template for the print header')
                ->end()
                ->scalarNode('footer_template')
                    ->info('HTML template for the print footer')
                ->end()
                ->booleanNode('display_header_footer')
                    ->info('Display header and footer')
                ->end()
            ->end()
        ;

        return $node;
    }
}
