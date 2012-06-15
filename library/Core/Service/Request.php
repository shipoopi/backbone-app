<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Core\Service;

use Core\Util\KeyValueStore,
    Core\Util\KeyValueStoreInterface;

/**
 * Description of Request
 *
 * @author hashin
 */
class Request
{
    private $params;
    private $post;
    private $get;
    private $request;
    private $server;
    private $env;
    private $cookie;
    private $method;
    private $methodKey = 'REQUEST_METHOD';
    private $methodOverride;
    private $overrideKey = 'X-HTTP-METHOD-OVERRIDE';
    
    public function __construct()
    {
        
        $this->post  = $_POST;
        $this->get   = $_GET;
        $this->request = $_REQUEST;
        $this->server = $_SERVER;
        $this->cookie = $_COOKIE;
        $this->env = $_ENV;
        $this->params = new KeyValueStore($this->request);
    }
    
    private function getOverride()
    {
        if (isset($this->server[$this->overrideKey])
            && !$this->methodOverride) {
            $this->methodOverride = strtolower(
                $this->server[$this->overrideKey]);
        }
        
        return $this->methodOverride;
    }
    
    public function getUrl()
    {
        return $_SERVER['REQUEST_URI'];
    }
    
    public function getMethod()
    {
        if (!$this->method 
            && isset($this->server[$this->methodKey])) {
            $this->method = strtolower($this->server[$this->methodKey]);
        }
        
        return $this->method;
    }
    
    public function isGet()
    {
        return $this->getMethod() == 'get'
            && !$this->isGetCollection();
    }
    
    public function isGetCollection()
    {
        if ($this->getMethod() != 'get') {
            return false;
        }
            
        if ($this->params->get('id')) {
            return false;
        }
        
        return true;
    }
    
    public function isPut()
    {
        if ($this->getMethod() != 'post'
            && $this->getMethod() != 'put') {
            return false;
        }
        
        if (!$this->params->get('id')) {
            return false;
        }
        
        return true;
    }
    
    public function isPost()
    {
        if ($this->getMethod() != 'post') {
            return false;
        }
        
        if ($this->params->get('id')) {
            return false;
        }
        
        return true;
    }
    
    public function isDelete()
    {
        if (!$this->params->get('id')) {
            return false;
        }
       
        if ($this->getMethod() != 'delete' 
            && !($this->getMethod() == 'post' 
            &&  $this->getOverride() == 'delete')) {
            return false;
        }

        return true;
            
    }
    
    public function setParams(array $params)
    {
        $this->params = new KeyValueStore($params);
        return $this;
    }
    
    public function addParams(array $params)
    {
        foreach ($params as $name => $val) {
            $this->params->set($name, $value);
        }
        return $this;
    }
    
    public function getParams()
    {
        return $this->params;
    }
    
    public function get($name)
    {
        return $this->params->get($name);
    }
    
    public function set($name, $value)
    {
        $this->params->set($name, $value);
        return $this;
    }
}