<?php

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{

	/**
	 * @inheritDoc
	 */
	public function getConfigTreeBuilder(): TreeBuilder
	{
		$treeBuilder = new TreeBuilder('symfony_status_logger');
		$root = $treeBuilder->getRootNode();
		$root->children()
			->scalarNode('path')
				->info('URL path to status page.')
				->cannotBeEmpty()
				->defaultValue('api/status')
			->end()
		->end();

		return $treeBuilder;
	}
}
