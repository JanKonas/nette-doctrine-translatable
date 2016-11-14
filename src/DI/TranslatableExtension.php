<?php

namespace Apploud\Doctrine\Translatable\DI;

use Apploud\Doctrine\Translatable\EventListener\TranslatableListener;
use Nette\DI\CompilerExtension;
use Nette\DI\ServiceDefinition;
use Nette\PhpGenerator\ClassType;

class TranslatableExtension extends CompilerExtension
{

	private $defaultConfig = [
		'entityManager' => null,
		'defaultLocale' => null,
		'currentLocale' => null,
		'fallbackLocale' => null,
		'currentLocaleResolver' => null,
		'fallbackLocaleResolver' => null,
	];

	public function loadConfiguration()
	{
		$builder = $this->getContainerBuilder();
		$config = array_merge($this->defaultConfig, $this->getConfig());
		$builder->addDefinition($this->prefix('listener'), $this->createListener($config));
	}

	public function afterCompile(ClassType $class)
	{
		$init = $class->getMethod('initialize');
		$originalInitialize = $init->getBody();
		$registerLoaderCall = 'Doctrine\Common\Annotations\AnnotationRegistry::registerLoader("class_exists");';
		if (strpos($originalInitialize, $registerLoaderCall) === false) {
			$init->setBody($registerLoaderCall . "\n");
			$init->addBody($originalInitialize);
		}
	}

	private function createListener(array $config)
	{
		$listener = new ServiceDefinition();
		$args = $config['entityManager'] ? [$config['entityManager']] : [];
		$listener->setClass(TranslatableListener::class, $args);
		$listener->addSetup('setDefaultLocale', [$config['defaultLocale']]);
		$listener->addSetup('setCurrentLocale', [$config['currentLocale']]);
		$listener->addSetup('setFallbackLocale', [$config['fallbackLocale']]);
		$listener->addSetup('setCurrentLocaleResolver', [$config['currentLocaleResolver']]);
		$listener->addSetup('setFallbackLocaleResolver', [$config['fallbackLocaleResolver']]);
		$listener->addTag('run');
		$listener->setInject(false);
		return $listener;
	}

}
