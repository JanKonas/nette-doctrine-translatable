nette-doctrine-translatable
======

Translatable behaviour extension for Doctrine2 as [Nette](https://nette.org) extension

[![Build Status](https://travis-ci.org/JanKonas/nette-doctrine-translatable.svg?branch=master)](https://travis-ci.org/JanKonas/nette-doctrine-translatable)

Installation
------------

The best way to install TranslationsConverter is using [Composer](http://getcomposer.org/):

```sh
$ composer require apploud/nette-doctrine-translatable
```

You can enable the extension using your neon config.

```yml
extensions:
	translatable: Apploud\Doctrine\Translatable\DI\TranslatableExtension
```

You also need to have an instance of `Doctrine\ORM\EntityManager` defined as a service with autowiring turned on (or pass it in configuration).

Configuration
------------

Configuration example with all possible settings:

```yml
translatable:
	entityManager: @doctrine.entityManager
	defaultLocale: defaultLocale
	currentLocale: currentLocale
	fallbackLocale: fallbackLocale
	currentLocaleResolver: [@resolverService, 'getCurrentLocale']
	fallbackLocaleResolver: [@resolverService, 'getFallbackLocale']
```

All settings are optional. If `entityManager` is missing, it will be autowired. Any other value defaults to `NULL`. Locale resolver can be any `callable`.

When determining current and fallback locales, priorities are:

1. locale value
2. value from locale resolver
3. default locale

Usage
------------

See [documentation of doctrine-translatable](https://github.com/JanKonas/doctrine-translatable/blob/master/doc/index.md)
