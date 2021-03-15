<?php

namespace Cravler\Print2PdfBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

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
                ->arrayNode('options')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->integerNode('timeout')
                            ->defaultValue(0)
                            ->info('Process timeout in seconds')
                        ->end()
                        ->floatNode('scale')
                            ->defaultValue(1)
                            ->info('Scale of the webpage rendering')
                        ->end()
                        ->floatNode('paper_width')
                            ->defaultValue(8.5)
                            ->info('Paper width in inches')
                        ->end()
                        ->floatNode('paper_height')
                            ->defaultValue(11)
                            ->info('Paper height in inches')
                        ->end()
                        ->floatNode('margin_top')
                            ->defaultValue(0)
                            ->info('Top margin in inches')
                        ->end()
                        ->floatNode('margin_bottom')
                            ->defaultValue(0)
                            ->info('Bottom margin in inches')
                        ->end()
                        ->floatNode('margin_left')
                            ->defaultValue(0)
                            ->info('Left margin in inches')
                        ->end()
                        ->floatNode('margin_right')
                            ->defaultValue(0)
                            ->info('Right margin in inches')
                        ->end()
                        ->scalarNode('page_ranges')
                            ->defaultValue('')
                            ->info('Paper ranges to print, e.g., "1-5, 8, 11-13"')
                        ->end()
                        ->booleanNode('ignore_invalid_page_ranges')
                            ->defaultValue(false)
                            ->info('Silently ignore invalid but successfully parsed page ranges, such as "3-2"')
                        ->end()
                        ->booleanNode('display_header_footer')
                            ->defaultValue(false)
                            ->info('Display header and footer')
                        ->end()
                        ->scalarNode('header_template')
                            ->defaultValue('')
                            ->info('HTML template for the print header')
                        ->end()
                        ->scalarNode('footer_template')
                            ->defaultValue('')
                            ->info('HTML template for the print footer')
                        ->end()
                        ->booleanNode('landscape')
                            ->defaultValue(false)
                            ->info('Landscape paper orientation')
                        ->end()
                        ->booleanNode('print_background')
                            ->defaultValue(false)
                            ->info('Print background graphics')
                        ->end()
                        ->booleanNode('prefer_css_page_size')
                            ->defaultValue(false)
                            ->info('Prefer page size defined by CSS')
                        ->end()
                    ->end()
                ->end()
                ->scalarNode('temporary_folder')
                    ->defaultValue(null)
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
