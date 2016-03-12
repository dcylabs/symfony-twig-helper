<?php

namespace Dcylabs\TwigBundle\Twig;

use Dcylabs\TwigBundle\Twig\TokenParser\CheckRolesTokenParser;
use Symfony\Component\DependencyInjection\Container;

class DcylabsTwigExtension extends \Twig_Extension
{

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFunction('checkRoles', array($this, 'checkRoles')),
        );
    }

    public function getTokenParsers(){
        return array(
          new CheckRolesTokenParser(),
        );
    }

    public function getName()
    {
        return 'dcylabs_twig_extension';
    }


    public function setTwigGlobals($container){
        $container->get('twig')->addGlobal('dcylabs_twig_serviceProvider', $container->get('dcylabs_twig.twig.serviceProvider'));
    }
}