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

You also need to have an instance of `Doctrine\ORM\EntityManager` defined as a service with autowiring turned on.

Usage
------------

See [documentation of doctrine-translatable](https://github.com/JanKonas/doctrine-translatable/blob/master/doc/index.md)
