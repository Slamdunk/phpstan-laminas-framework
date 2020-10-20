# PHPStan extension for Laminas Framework

[![Latest Stable Version](https://img.shields.io/packagist/v/slam/phpstan-laminas-framework.svg)](https://packagist.org/packages/slam/phpstan-laminas-framework)
[![Downloads](https://img.shields.io/packagist/dt/slam/phpstan-laminas-framework.svg)](https://packagist.org/packages/slam/phpstan-laminas-framework)
[![Integrate](https://github.com/Slamdunk/phpstan-laminas-framework/workflows/Integrate/badge.svg?branch=master)](https://github.com/Slamdunk/phpstan-laminas-framework/actions)
[![Code Coverage](https://codecov.io/gh/Slamdunk/phpstan-laminas-framework/coverage.svg?branch=master)](https://codecov.io/gh/Slamdunk/phpstan-laminas-framework?branch=master)

* [PHPStan](https://phpstan.org/)
* [Laminas Framework](https://getlaminas.org/)

This extension provides following features:

1. Provide correct return for `\Laminas\ServiceManager\ServiceLocatorInterface::get()`
1. Handle controller plugins that are called using magic `__call()` in subclasses of
`\Laminas\Mvc\Controller\AbstractController`
1. Provide correct return type for `plugin` method of `AbstractController`, `FilterChain`, `PhpRenderer` and `ValidatorChain`
1. `getApplication()`, `getRenderer()`, `getRequest()` and `getResponse()` methods on Controllers, MvcEvents, View,
ViewEvent and Application returns the real instance instead of type-hinted interfaces
1. `getView()` method on `\Laminas\View\Helper\AbstractHelper` returns the real Renderer instance instead of type-hinted
interface
1. `\Laminas\Stdlib\ArrayObject` is configured as a [Universal object crate](https://phpstan.org/config-reference#universal-object-crates)
1. Handle `\Laminas\Stdlib\AbstractOptions` magic properties

## Installation

To use this extension, require it in [Composer](https://getcomposer.org/):

```
composer require --dev slam/phpstan-laminas-framework
```

If you also install [phpstan/extension-installer](https://github.com/phpstan/extension-installer) then you're all set!

<details>
    <summary>Manual installation</summary>

If you don't want to use `phpstan/extension-installer`, include extension.neon in your project's PHPStan config:

```
includes:
    - vendor/slam/phpstan-laminas-framework/extension.neon
```

</details>

## Configuration

This library already recognize built-in services and plugins.

You can opt in for more advanced analysis by providing the service manager from your own application:

```neon
parameters:
    laminasframework:
       serviceManagerLoader: tests/service-manager.php
```

For example, `tests/service-manager.php` would look something like this:

```php
$app = \Laminas\Mvc\Application::init($config);
return $app->getServiceManager();
```
