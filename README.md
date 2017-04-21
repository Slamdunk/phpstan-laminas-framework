# An extension for PHPStan to inform it of zend-mvc plugins
Tells PHPStan about the Params class, specifically it's use in a controller as
$this->params();

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


