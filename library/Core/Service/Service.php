<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core\Service;

use Core\Util\ArrayRepresentable,
    Core\Util\KeyValueStoreInterface,
    Core\Util\Pipe\PipeInterface;

/**
 * Description of Service
 *
 * @author hashinpanakkaparambil
 */
class Service implements ArrayRepresentable, PipeInterface
{

    private $name;
    private $class;
    private $url;
    private $methods = array();
    private $callable;

    public function __construct(
        $name, $class, $url, $methods = array())
    {
        $this->name = $name;
        $this->class = $class;
        $this->url = $url;
        $this->methods = $methods;
    }
    
    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getClass()
    {
        return $this->class;
    }

    public function setClass($class)
    {
        $this->class = $class;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function getMethods()
    {
        return $this->methods;
    }

    public function setMethods($methods)
    {
        $this->methods = $methods;
    }
    
    public function setCallable($controller, $method)
    {
        $this->callable = array($controller, $method);
    }
    
    public function addMethod($httpMethod, $fulfilmentMethod)
    {
        $httpMethod = (string) $httpMethod;
        $fulfilmentMethod = (string) $fulfilmentMethod;
        $this->methods[$httpMethod] = $fulfilmentMethod;
        return $this;
    }
    
    public function toArray()
    {
        return array(
            'service' => $this->name,
            'className' => $this->class,
            'url' => $this->url,
            'methods' => $this->methods);
    }

    public function flow(KeyValueStoreInterface $bus)
    {
        $request = $bus->get('request');
        $serviceResponse = 
            call_user_func_array($this->callable, array($request));
        $bus->set('serviceResult', $serviceResponse);
    }

}