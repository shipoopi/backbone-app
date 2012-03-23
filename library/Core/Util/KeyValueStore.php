<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Core\Util;

/**
 * Description of KeyValueStore
 *
 * @author hashin
 */
class KeyValueStore extends \ArrayObject
{
    public function set($name, $value)
    {
        $this[(string) $name] = $value;
    }
    
    public function get($name)
    {
        if (!isset($name)) {
            throw new \InvalidArgumentException('Key can not be null');
        }
        
        $name = (string) $name;
        $value = null;
        if ($this->offsetExists($name)) {
            $value = $this[$name];
        }
        
        return $value;

    }
}