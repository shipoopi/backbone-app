<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Core\Service\Representations;

use Core\Service\Representations\RepresentationInterface;

/**
 * Description of HtmlRepresentation
 *
 * @author hash
 */
class RepresentationFromFile extends \ArrayObject implements RepresentationInterface
{
    private $template;
    private $content;
    
    public function __construct(array $vars, $template)
    {
        parent::__construct($vars);
        if (!is_readable($template)) {
            throw new \InvalidArgumentException(sprintf(
                    'File is not %s readable', $template));
        }
        
        foreach ($vars as $key => $val) {
            $this->$key = $val;
        }
        
        $this->template = $template;
    }

    public function getAsString()
    {
        if ($this->content) {
            return $this->content;
        }
        
        ob_start();
        include $this->template;
        $str = ob_get_clean();
        return $str;
    }
    
    public function __toString()
    {
        return $this->getAsString();
    }
}
