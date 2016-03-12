<?php

namespace Dcylabs\TwigBundle\Service;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\AccessMap;

class PathRoles{

    private $container;
    private $access_map;

    public function __construct(Container $container, $access_map){
        $this->container = $container;
        $this->access_map = $access_map;
    }

    public function cleanUrl(Request $request){
        $basePath = $this->container->get('request')->getBaseUrl();
        $server = $request->server;
        $server->set('REQUEST_URI',str_replace($basePath,'',$server->get('REQUEST_URI')));
    }

    public function getRoles($path){ //$path is the path you want to check access to
        $request = Request::create($path,'GET');
        $this->cleanUrl($request);
        list($roles,$channel) = $this->access_map->getPatterns($request);//get access_control for this request
        return $roles;
    }

    public function checkPath($path){
        $roles = $this->getRoles($path);
        if(is_null($roles)) return true;
        foreach($roles as $role) {
            if ($this->container->get('security.authorization_checker')->isGranted($role)){
                return true;
            }
        }
        return false;
    }

}