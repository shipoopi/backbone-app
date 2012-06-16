<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Core\Service;

use Core\Util\KeyValueStore,
    Core\Util\KeyValueStoreInterface;

/**
 * Description of ControllerBus
 *
 * @author hashin
 */
class ServiceBus implements KeyValueStoreInterface
{
    private $request;
    private $response;
    private $dispatched = false;
    private $pool;
    
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
        $this->pool = new KeyValueStore();
    }
    
    public function get($name)
    {
        return $this->pool->get($name);
    }
    
    public function set($name, $value)
    {
        if (property_exists($this, $name) && $name != 'pool') {
            $this->$name = $value;
        }
        
        $this->pool->set($name, $value);
        return $this;
    }
    
    public function getRequest()
    {
        return $this->request;
    }
    
    public function getResponse()
    {
        return $this->response;
    }
    
    public function isDispatched()
    {
        return $this->dispatched;
    }
    
    public function setDispatched($flag)
    {
        $this->dispatched = (bool) $flag;
        return $this;
    }
}