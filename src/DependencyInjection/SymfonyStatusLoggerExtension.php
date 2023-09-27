<?php

namespace Tahicz\SymfonyStatusLoggerBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class SymfonyStatusLoggerExtension extends Extension
{
	/**
	 * @inheritDoc
	 */
	public function load(array $configs, ContainerBuilder $container): void
	{
		$loader = new XmlFileLoader($container, new FileLocator(dirname(__DIR__) . '/Resources/config'));
		$loader->load('status-logger-config.xml');

		$configuration = new Configuration();
		$config = $this->processConfiguration($configuration, $configs);

		$container->setParameter('symfony_status_logger.path', $config['path']);
	}
}
