<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Core\Service;

use Core\Util\KeyValueStore;

/**
 * Description of ControllerBus
 *
 * @author hashin
 */
class ControllerBus
{
    private $pool;
    
    public function __construct()
    {
        $this->pool = new KeyValueStore();
    }
    
    public function get($name)
    {
        return $this->pool->get($name);
    }
    
    public function set($name, $value)
    {
        $this->pool->set($name, $value);
    }
}