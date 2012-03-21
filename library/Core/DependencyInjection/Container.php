<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core\DependencyInjection;

use Core\Transformation\ObjectFactoryV2,
    Core\Util\Validator;

/**
 * Dependency injection container
 *
 * @author hashinpanakkaparambil
 */
class Container
{

    /**
     * Holds the name type mappings
     * @var array
     */
    private $dependencies = array();

    /**
     * Holds the type mappings
     *  'interface' => array(
     *      'instanciable' => 'Class', 'configuredObject' => object
     *   )
     * When a type is registered with the container its implementing interface
     * mappings are also generated
     * 
     * @var array
     */
    private $registeredTypes = array();

    /**
     * Holds the interfaces implemented by a class and the class type itself
     * 
     *   'class' = array('interface1', 'interface2')
     * @var array 
     */
    private $superTypes = array();

    /**
     * Instanciates a class without calling its constructor
     * 
     * @param string $class
     * @return mixed 
     */
    public function newInstance($class)
    {
        $prototype = unserialize(sprintf(
                'O:%d:"%s":0:{}', strlen($class), $class));

        return clone $prototype;
    }

    /**
     * Container constructor
     * 
     * Accepts an optional dependencies parameter that should be valid 
     * name => type mappings
     * @param array $dependencies optional
     */
    public function __construct(array $dependencies = array())
    {
        foreach ($dependencies as $dependency => $type) {
            $this->registerDependency($dependency, $type);
        }
    }

    /**
     * Returns a dependency for the given dependency key
     * 
     * @param string $key
     * @return mixed 
     */
    public function get($key, $throwException = true)
    {
        if (!isset($this->dependencies[$key])) {
            if ($throwException) {
                throw new \RuntimeException(sprintf(
                        'Dependency %s not registered', $key));
            } else {
                return false;
            }
        }

        $type = $this->dependencies[$key];

        return $this->getType($type, $throwException);
    }

    /**
     * Returns a dependency for the given type if that type is registered
     * 
     * If throw exception is true this function will throw an exception 
     * if the type is not already registered. If false and type is 
     * not found a boolean false is returned. Default is true
     * 
     * @param string $type
     * @param boolean $throwException
     * @return boolean|mixed
     * @throws \RuntimeException 
     */
    public function getType($type, $throwException = true)
    {
        Validator::nonEmptyString($type, 'Type should be a valid string');
        $type = (string) $type;

        //check if the type is registered
        if (!isset($this->registeredTypes[$type])) {
            if ($throwException) {
                throw new \RuntimeException(sprintf(
                        'Type %s not registered', $type));
            } else {
                return false;
            }
        }

        //check if the type is already instanciated
        if (isset($this->registeredTypes[$type]['configuredObject'])) {
            return $this->registeredTypes[$type]['configuredObject'];
        }

        //if control reaches here it means the object is not instanciated yet
        $instanciable = $this->registeredTypes[$type]['instanciable'];
        $configured = $this->newInstance($instanciable);
        //super type array will contain any implementing interfaces,
        //inherting objects and the type of the dependency itself.
        //This array is populated in registerDependency function
        foreach ($this->superTypes[$instanciable] as $superType) {
            $this->registeredTypes[$superType]['configuredObject']
                = $configured;
        }

        $dependency = new Dependency($this, $configured);
        $dependency->configureInstance();

        return $configured;
    }

    /**
     * Registers a dependency
     * 
     * All implementing interfaces are also registered
     * 
     * @param string $dependency
     * @param string $instantiable
     * @throws \InvalidArgumentException 
     */
    public function registerDependency($dependency, $instantiable)
    {
        Validator::nonEmptyString($dependency,
                                  'Dependency name should be a string');
        $dependency = (string) $dependency;

        Validator::nonEmptyString($instantiable,
                                  'Instanciable should be a valid class name');
        $instanciable = (string) $instantiable;

        Validator::classExists($instanciable,
                               sprintf(
                'Class %s not found', $instanciable));

        $reflectionClass = new \ReflectionClass($instanciable);

        //check if it is instanciable
        if (!$reflectionClass->isInstantiable()) {
            throw new \InvalidArgumentException(
                'Type %s is not instanciable', $instanciable);
        }

        $this->dependencies[$dependency] = $instanciable;

        //create type mappings
        //register the instantiable itself
        $this->registeredTypes[$instanciable]['instanciable'] = $instanciable;
        $this->superTypes[$instanciable][] = $instanciable;

        //instantiable is also instances of implementing interfaces

        foreach ($reflectionClass->getInterfaceNames() as $interface) {
            $this->registeredTypes[$interface]['instanciable'] = $instanciable;
            $this->superTypes[$instanciable][] = $interface;
        }
    }

}