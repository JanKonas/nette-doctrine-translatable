<?php

namespace Apploud\Doctrine\Translatable\DI;

use Apploud\Doctrine\Translatable\EventListener\TranslatableListener;
use Nette\DI\CompilerExtension;
use Nette\DI\ServiceDefinition;
use Nette\PhpGenerator\ClassType;

class TranslatableExtension extends CompilerExtension
{

	public function loadConfiguration()
	{
		$builder = $this->getContainerBuilder();
		$builder->addDefinition($this->prefix('listener'), $this->createListener());
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

	private function createListener()
	{
		$listener = new ServiceDefinition();
		$listener->setClass(TranslatableListener::class);
		$listener->addTag('run');
		$listener->setInject(false);
		return $listener;
	}

}
