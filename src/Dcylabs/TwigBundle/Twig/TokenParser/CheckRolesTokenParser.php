<?php

namespace Dcylabs\TwigBundle\Twig\TokenParser;

use Dcylabs\TwigBundle\Twig\Node\CheckRolesNode;

class CheckRolesTokenParser extends \Twig_TokenParser{


    public function parse(\Twig_Token $token)
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();
        $paths = array();
        $alternativeBody = null;
        while (!$stream->test(\Twig_Token::BLOCK_END_TYPE)) {
            array_push($paths,$this->parser->getExpressionParser()->parseExpression());
        }
        $stream->expect(\Twig_Token::BLOCK_END_TYPE);

        if(empty($paths)){
            throw new \Twig_Error_Syntax('checkRoles expect at least one path, none given');
        }

        $body = $this->parser->subparse(array($this, 'decideForFork'));
        $next = $stream->next()->getValue();
        if($next == 'else'){
            $stream->expect(\Twig_Token::BLOCK_END_TYPE);
            $alternativeBody = $this->parser->subparse(array($this, 'decideForEnd'), true);
        }
        $stream->expect(\Twig_Token::BLOCK_END_TYPE);

        $nodes = array();
        $attributes = array(
            'paths' => $paths,
            'body' => $body,
            'alternativeBody' => $alternativeBody
        );

        return new CheckRolesNode($nodes, $attributes, $lineno, $this->getTag());
    }

    public function getTag()
    {
        return 'checkRoles';
    }

    public function decideForFork(\Twig_Token $token)
    {
        return $token->test(array('else', 'endcheckRoles'));
    }

    public function decideForEnd(\Twig_Token $token)
    {
        return $token->test('endcheckRoles');
    }

}