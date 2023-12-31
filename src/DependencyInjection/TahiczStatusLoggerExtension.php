<?php

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class TahiczStatusLoggerExtension extends Extension
{
	/**
	 * @inheritDoc
	 */
	public function load(array $configs, ContainerBuilder $container): void
	{
//		$loader = new PhpFileLoader(
//			$container,
//			new FileLocator(__DIR__.'/../Resources/config')
//		);
//		$loader->load('tahicz-status-logger.php');

//		$loader = new YamlFileLoader(
//			$container,
//			new FileLocator(__DIR__.'/../Resources/config')
//		);
//		$loader->load('routes.yaml');

		$container->setParameter('tahicz_status_logger.path', 'api/status');
	}
}
