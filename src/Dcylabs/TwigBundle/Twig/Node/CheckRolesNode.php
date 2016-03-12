<?php

namespace Dcylabs\TwigBundle\Twig\Node;

use Symfony\Component\DependencyInjection\Container;

class CheckRolesNode extends DcylabsTwigNode{

    public function __construct($nodes, $attributes, $line, $tag = null)
    {
        parent::__construct($nodes, $attributes, $line, $tag);
    }

    public function compile(\Twig_Compiler $compiler)
    {

        $varsToUnset = array();

        // Rights verification
        $compiler->write('$allowed = true; '."\n");
        foreach($this->getAttribute('paths') as $path){
            $compiler->write('$allowed = $context[\'dcylabs_twig_serviceProvider\']->get(\'path_roles\')->checkPath( '."\n")
                ->subcompile($path)
                ->write(') ? $allowed : false ;'."\n");
        }

        $compiler->write('if($allowed){ '."\n");

            // Variable generation
            if(count($this->getAttribute('paths')) > 1){
                foreach($this->getAttribute('paths') as $path) {
                    $this->setVar($compiler, '$context[\'check_urls\'][]', $path);
                }
                array_push($varsToUnset,'check_urls');
            }
            $this->setVar($compiler, '$context[\'check_url\']', $this->getAttribute('paths')[0]);
            array_push($varsToUnset,'check_url');

            $compiler->subcompile($this->getAttribute('body'));

        if(!is_null($this->getAttribute('alternativeBody'))){
            $compiler->write('} else { '."\n");
            $compiler->subcompile($this->getAttribute('alternativeBody'));
        }

        $compiler->write('} '."\n");
        foreach($varsToUnset as $var){
            $this->unsetVar($compiler, '$context[\''.$var.'\']');
        }

    }

}