<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Core\DependencyInjection\Injections;

/**
 * Description of InjectByType
 *
 * @author hashinpanakkaparambil
 * @Annotation
 */
class InjectType
{
    private $reflectionProperty;
    public $value;
    public $mandatory = true;
    
    public function setReflectionProperty(\ReflectionProperty $prop)
    {
        $this->reflectionProperty = $prop;
    }
    
    public function getReflectionProperty()
    {
        return $this->reflectionProperty;
    }   
}

/**
 * @Annotation 
 */
class Inject
{
    private $reflectionProperty;
    public $value;
    public $mandatory = true;
    
    public function setReflectionProperty(\ReflectionProperty $prop)
    {
        $this->reflectionProperty = $prop;
    }
    
    public function getReflectionProperty()
    {
        return $this->reflectionProperty;
    }
}

/**
 * @Annotation 
 */
class Value
{
    private $reflectionProperty;
    public $value;
    public $mandatory = true;
    
    public function setReflectionProperty(\ReflectionProperty $prop)
    {
        $this->reflectionProperty = $prop;
    }
    
    public function getReflectionProperty()
    {
        return $this->reflectionProperty;
    }
}

/**
 *  @Annotation 
 */
class Configurable
{
    public $value;
    public $mandatory = false;
}