<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Core\Service\Representations;

/**
 * Description of StringRepresntations
 *
 * @author hash
 */
class StringRepresentation implements RepresentationInterface
{
    private $content = '';
    
    public function __construct($content)
    {
        $this->content = (string) $content;
    }
    
    public function getAsString()
    {
        return $this->content;
    }
    
    public function __toString()
    {
        return $this->content;
    }
}
