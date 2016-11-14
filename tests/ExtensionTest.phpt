<?php

namespace Apploud\Doctrine\Translatable\Tests;

require __DIR__ . '/BaseTest.php';

use Apploud\Doctrine\Translatable\EventListener\TranslatableListener;
use Tester\Assert;

class ExtensionTest extends BaseTest
{

	public function testFunctionality()
	{
		/** @var TranslatableListener $export */
		$listener = $this->container->getByType('Apploud\Doctrine\Translatable\EventListener\TranslatableListener');
		Assert::type(TranslatableListener::class, $listener);
	}

}

$test = new ExtensionTest();
$test->run();
