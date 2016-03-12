<?php

namespace Dcylabs\TwigBundle\Twig\Node;

use Symfony\Component\DependencyInjection\Container;

class DcylabsTwigNode extends \Twig_Node{

    public function __construct($nodes, $attributes, $line, $tag = null)
    {
        parent::__construct($nodes, $attributes, $line, $tag);
    }

    public function setVar($compiler, $name, $value){
        $compiler->write($name.' = ')
            ->subcompile($value)
            ->write(";\n");
    }

    public function unsetVar($compiler, $name){
        $compiler->write('unset('.$name.') ;'."\n");
    }


}