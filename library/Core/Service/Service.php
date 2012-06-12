<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core\Service;

use Core\Util\ArrayRepresentable;

/**
 * Description of Service
 *
 * @author hashinpanakkaparambil
 */
class Service implements ArrayRepresentable
{

    private $name;
    private $class;
    private $url;
    private $methods = array();

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
            'name' => $this->name,
            'className' => $this->class,
            'url' => $this->url,
            'methods' => $this->methods);
    }

    
}