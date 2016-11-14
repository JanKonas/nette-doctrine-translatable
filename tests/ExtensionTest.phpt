<?php

namespace Apploud\Doctrine\Translatable\Tests;

require __DIR__ . '/BaseTest.php';

use Apploud\Doctrine\Translatable\EventListener\TranslatableListener;
use Tester\Assert;

class ExtensionTest extends BaseTest
{

	public function testBareExtension()
	{
		$this->createContainer('bare');
		/** @var TranslatableListener $export */
		$listener = $this->container->getByType('Apploud\Doctrine\Translatable\EventListener\TranslatableListener');
		Assert::type(TranslatableListener::class, $listener);
	}

	public function testBasicConfiguration()
	{
		$this->createContainer('basic');
		/** @var TranslatableListener $export */
		$listener = $this->container->getByType('Apploud\Doctrine\Translatable\EventListener\TranslatableListener');
		Assert::type(TranslatableListener::class, $listener);
		Assert::same('currentLocale', $listener->getCurrentLocale());
		Assert::same('fallbackLocale', $listener->getFallbackLocale());
		$listener->setCurrentLocale(null);
		$listener->setFallbackLocale(null);
		Assert::same('resolved-current', $listener->getCurrentLocale());
		Assert::same('resolved-fallback', $listener->getFallbackLocale());
		$listener->setCurrentLocaleResolver(null);
		$listener->setFallbackLocaleResolver(null);
		Assert::same('defaultLocale', $listener->getCurrentLocale());
		Assert::same('defaultLocale', $listener->getFallbackLocale());
	}

}

class LocaleResolver
{
	private $locale;

	public function __construct($locale)
	{
		$this->locale = $locale;
	}

	public function getLocale()
	{
		return $this->locale;
	}
}

$test = new ExtensionTest();
$test->run();
