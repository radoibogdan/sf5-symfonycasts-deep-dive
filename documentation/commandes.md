# Titre
[Example url][1]

To Do
```bash
$ php bin/console debug:container http_kernel --show-arguments
$ php bin/console debug:container debug.controller_resolver --show-arguments
$ php bin/console debug:container debug.controller_resolver.inner --show-arguments
$ php bin/console debug:container parameter_bag
$ php bin/console debug:container --tag=controller.argument_value_resolver
```

## Démarrer serveur en local
```bash
$ symfony serve -d
```
Lien pour accéder à l'interface: https://127.0.0.1:8000

HttpKernel  
ControllerEvent  
ControllerResolver  
RequestAttributeResolver  
ArgumentResolver  

ResponseListener

ErrorController  
ErrorListener -> sets the Response on the exception event  
FlattenException  
SerializerErrorRenderer  
    ->render()  
    ->getPrefferedFormat() => return 'html, json etc.'  
Response->prepare()  
ProblemNormalizer (Takes an object => converts in an array of data)

TwigErrorRenderer  
    ->render  
    ->findTemplate (used to personalize error pages based on error code)
HtmlErrorRenderer  
    ->render  
    ->renderException (builds exception page)  
exception_full.html.php

# Entity Arguments
ParamConverterListener  
DoctrineParamConverter  


# Tests (pas sur ce projet)
Jouer les tests (srs/tests):

```bash
$ php bin/phpunit
```

[1]: https://example.com