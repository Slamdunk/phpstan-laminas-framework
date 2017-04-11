# An extension for PHPStan to inform it of zend-mvc plugins
Tells PHPStan about the Params class, specifically it's use in a controller as
$this->params();

# Open questions:

- Am I creating the ParamsMethodReflection correctly in
  ParamsMethodsClassReflectionExtension::getMethod?
- I had to modify the return type on getPrototype from self to
  MethodReflection.  Is this OK?
- I've hardcoded the string 'params' in two places.  Is this correct?
- Is it best practice to pile other AbstractController plugins into this one extension?
  plugins? (e.g. flashMessenger, redirect).
- Should other Zend Framework methods that PHPStan can't figure out be piled
  into this extension or separate ones?  How to organise?


