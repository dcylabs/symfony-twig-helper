Installing Dcylabs Twig Bundle 
======================================

## Updating composer.json

``` json
  "require": {
      "dcylabs/symfony-twig-helper": "dev-master"
  }
```

## Updating AppKernel.php

``` php
  // app/AppKernel.php
  $bundles = array(
    // ...
    new Dcylabs\TwigBundle\DcylabsTwigBundle(),
  );
```

Using Dcylabs Twig Bundle 
======================================

## Checking roles 
``` twig 
    {% checkRoles '/myPath' %}
        If I can read this I have the rights on the url : "{{ check_url }}"
    {% else %}
        I don't have the rights 
    {% endcheckRoles %}
```

``` twig 
    {% checkRoles '/pathOne' '/pathTwo' '/pathThree' %}
        If I can read this I have the rights on the urls : "{{ check_urls | join(';') }}"
    {% else %}
        I don't have the rights 
    {% endcheckRoles %}
```
