# PHPStan extension for Zend Framework MVC Controller Plugins
Adds support to PHPStan to correctly handle controller plugins that are called
using magic `__call()` in `\Zend\Mvc\Controller\AbstractController` and
children.

## Installation
- Add `michaelgooden/phpstan-zend-mvc` as a `require-dev` Composer dependency
- Add the following to phpstan.neon in your top-level app directory
```
services:
    -
        class: PHPStan\Reflection\ZendMvc\PluginClassReflectionExtension
        tags:
            - phpstan.broker.methodsClassReflectionExtension
```
- Run PHPStan with the config file switch `phpstan -c phpstan.neon`
