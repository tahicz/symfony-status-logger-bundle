<?php

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;

class SymfonyStatusLoggerExtension extends Extension
{
	/**
	 * @inheritDoc
	 */
	public function load(array $configs, ContainerBuilder $container): void
	{
		$configuration = new Configuration();
		$config = $this->processConfiguration($configuration, $configs);

		$container->setParameter('tahicz_status_logger.path', $config['path']);
	}
}
