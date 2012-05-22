<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Core\Service;

use Core\Util\KeyValueStore;

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
    
    public function __construct()
    {
        $this->params = new KeyValueStore();
        $this->post  = $_POST;
        $this->get   = $_GET;
        $this->request = $_REQUEST;
        $this->server = $_SERVER;
        $this->cookie = $_COOKIE;
        $this->env = $_ENV;
    }
    
    public function getUrl()
    {
        return $_SERVER['REQUEST_URI'];
    }
    
    public function isGet()
    {
        return isset($this->server['REQUEST_METHOD'])
            && strtolower($this->server['REQUEST_METHOD']) == 'get';
    }
    
}