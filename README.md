# An extension for PHPStan to inform it of zend-mvc plugins
Allows PHPStan to understand Zend Framework plugins, e.g. the Params class when used like $this->params() in a controller.

# Installation
- Clone this repo and put it under your mdoule/Application/src/
- Add the following to phpstan.neo in your top-level app directory
```
services:
    -
        class: Application\PHPStan\PluginClassReflectionExtension
        tags:
            - phpstan.broker.methodsClassReflectionExtension
```

# Open questions:

- My names are likely atrocious - need feedback.
- Is module\Application\PHPStan the best place for something like this?


