<?php

namespace Tahicz\SymfonyStatusLoggerBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class SymfonyStatusLoggerExtension extends Extension
{
	/**
	 * @inheritDoc
	 */
	public function load(array $configs, ContainerBuilder $container): void
	{
		$loader = new YamlFileLoader($container, new FileLocator(dirname(__DIR__) . '/Resources'));
		$loader->load('services.yaml');
		$loader->load('route.yaml');

		$configuration = new Configuration();
		$config = $this->processConfiguration($configuration, $configs);

		$container->setParameter('symfony_status_logger.path', $config['path']);
	}
}
