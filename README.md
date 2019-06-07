# PHPStan extension for Zend Framework

[![Build Status](https://travis-ci.org/Slamdunk/phpstan-zend-framework.svg?branch=master)](https://travis-ci.org/Slamdunk/phpstan-zend-framework)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Slamdunk/phpstan-zend-framework/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Slamdunk/phpstan-zend-framework/?branch=master)
[![Packagist](https://img.shields.io/packagist/v/slam/phpstan-zend-framework.svg)](https://packagist.org/packages/slam/phpstan-zend-framework)
[![Total Downloads](https://img.shields.io/packagist/dt/slam/phpstan-zend-framework.svg)](https://packagist.org/packages/Slamdunk/phpstan-zend-framework)

* [PHPStan](https://github.com/phpstan/phpstan)
* [Zend Framework](https://framework.zend.com/)

This extension provides following features:

1. Provide correct return for `\Zend\ServiceManager\ServiceLocatorInterface::get()`
1. Handle controller plugins that are called using magic `__call()` in subclasses of
`\Zend\Mvc\Controller\AbstractController`
1. `getApplication()`, `getRequest()` and `getResponse()` methods on Controllers, MvcEvents, View, ViewEvent and Application
returns the real instance instead of type-hinted interfaces
1. `getView()` method on `\Zend\View\Helper\AbstractHelper` returns the real Renderer instance instead of type-hinted
interface
1. `\Zend\Stdlib\ArrayObject` is configured as a [Universal object crate](https://github.com/phpstan/phpstan#universal-object-crates)

## Installation

To use this extension, require it in [Composer](https://getcomposer.org/):

```
composer require --dev slam/phpstan-zend-framework
```

If you also install [phpstan/extension-installer](https://github.com/phpstan/extension-installer) then you're all set!

<details>
    <summary>Manual installation</summary>

If you don't want to use `phpstan/extension-installer`, include extension.neon in your project's PHPStan config:

```
includes:
    - vendor/slam/phpstan-zend-framework/extension.neon
```

</details>

## Configuration

This library already recognize built-in services and plugins.

You can opt in for more advanced analysis by providing the service manager from your own application:

```neon
parameters:
    zendframework:
       serviceManagerLoader: tests/service-manager.php
```

For example, `tests/service-manager.php` would look something like this:

```php
$app = \Zend\Mvc\Application::init($config);
return $app->getServiceManager();
```
