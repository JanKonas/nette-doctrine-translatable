<?php

namespace Apploud\Doctrine\Translatable\EventListener;

use Doctrine\ORM\EntityManager;
use Metadata\MetadataFactory;
use Prezent\Doctrine\Translatable\EventListener\TranslatableListener as PrezentListener;
use Prezent\Doctrine\Translatable\Mapping\Driver\DoctrineAdapter;

class TranslatableListener extends PrezentListener
{

	public function __construct(EntityManager $entityManager)
	{
		$driver = DoctrineAdapter::fromManager($entityManager);
		$metadataFactory  = new MetadataFactory($driver);
		parent::__construct($metadataFactory);
		$entityManager->getEventManager()->addEventSubscriber($this);
	}

}
