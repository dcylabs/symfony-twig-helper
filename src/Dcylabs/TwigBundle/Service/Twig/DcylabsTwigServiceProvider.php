<?php

namespace Dcylabs\TwigBundle\Service\Twig;

use Symfony\Component\DependencyInjection\Container;

class DcylabsTwigServiceProvider{

    private $container;

    public function __construct(Container $container){
        $this->container = $container;
    }

    public function get($service){
        return $this->container->get('dcylabs_twig.'.$service);
    }

}