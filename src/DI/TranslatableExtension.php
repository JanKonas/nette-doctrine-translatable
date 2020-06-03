<?php

namespace Apploud\Doctrine\Translatable\DI;

use Apploud\Doctrine\Translatable\EventListener\TranslatableListener;
use Nette\DI\CompilerExtension;
use Nette\DI\Definitions\ServiceDefinition;
use Nette\DI\Extensions\InjectExtension;
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

	public function loadConfiguration(): void
	{
		$builder = $this->getContainerBuilder();
		$config = array_merge($this->defaultConfig, $this->getConfig());
		$builder->addDefinition($this->prefix('listener'), $this->createListener($config));
	}

	public function afterCompile(ClassType $class): void
	{
		$init = $class->getMethod('initialize');
		$originalInitialize = $init->getBody();
		$registerLoaderCall = 'Doctrine\Common\Annotations\AnnotationRegistry::registerLoader("class_exists");';
		if (strpos($originalInitialize, $registerLoaderCall) === false) {
			$init->setBody($registerLoaderCall . "\n");
			$init->addBody($originalInitialize);
		}
	}

	private function createListener(array $config): ServiceDefinition
	{
		$listener = new ServiceDefinition();
		$args = $config['entityManager'] ? [$config['entityManager']] : [];
		$listener->setFactory(TranslatableListener::class, $args);
		$listener->addSetup('setDefaultLocale', [$config['defaultLocale']]);
		$listener->addSetup('setCurrentLocale', [$config['currentLocale']]);
		$listener->addSetup('setFallbackLocale', [$config['fallbackLocale']]);
		$listener->addSetup('setCurrentLocaleResolver', [$config['currentLocaleResolver']]);
		$listener->addSetup('setFallbackLocaleResolver', [$config['fallbackLocaleResolver']]);
		$listener->addTag(InjectExtension::TAG_INJECT, false);
		return $listener;
	}

}
