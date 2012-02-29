<?php

namespace Nodrew\Bundle\DfpBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * @package     NodrewDfpBundle
 * @author      Drew Butler <hi@nodrew.com>
 * @copyright	(c) 2012 Drew Butler
 * @license     http://www.opensource.org/licenses/mit-license.php
 */
class Configuration
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTree()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('nodrew_dfp', 'array');

        $rootNode
            ->children()
                ->scalarNode('api_key')->isRequired()->cannotBeEmpty()->end()
            ->end()
        ;

        return $treeBuilder->buildTree();
    }
}

