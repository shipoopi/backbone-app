<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core\DependencyInjection;

use Doctrine\Common\Annotations\AnnotationReader,
    Doctrine\Common\Annotations\AnnotationRegistry;

/**
 * A dependency. Manages how the dependency is configured
 *
 * @author hashinpanakkaparambil
 */
class Dependency
{

    /**
     * Container
     * @var Container 
     */
    private $container;

    /**
     * The dependency instance being configured
     * @var type 
     */
    private $instance;

    /**
     * A reflected version of instance
     * @var \ReflectionObject
     */
    private $reflectedInstance;

    /**
     * Reflected properties of instance
     * 
     * @var array
     */
    private $reflectedProperties = array();

    /**
     * Doctrine annotation reader
     * 
     * @var AnnotationReader
     */
    private $annotationReader;

    /**
     * Whether injections are already read
     * 
     * @var boolean
     */
    private $injectionsRead = false;

    /**
     * Whether the instance is already configured
     * 
     * @var boolean
     */
    private $instanceConfigured = false;

    /**
     * Holds type injections defined in the instance
     * 
     * @var type 
     */
    private $typeInjections = array();
    private $nameInjections = array();

    /**
     * Constructor
     * 
     * @param Container $container
     * @param mixed $instance 
     */
    public function __construct(Container $container, $instance)
    {
        $this->container = $container;
        $this->instance = $instance;
        $this->reflectedInstance = new \ReflectionObject($instance);
        $this->reflectedProperties = $this->reflectedInstance->getProperties();
        $currentDirectory = dirname(__FILE__);
        AnnotationRegistry::registerFile(
            $currentDirectory . '/Injections/DoctrineAnnotations.php');
        $this->annotationReader = new AnnotationReader();
    }

    /**
     * Reads the injections 
     * 
     * @return boolean 
     */
    private function readInjections()
    {
        if ($this->injectionsRead) {
            return true;
        }

        //read properties
        foreach ($this->reflectedProperties as $reflectedProp) {

            $injectAnnotation = 'Core\DependencyInjection\Injections\InjectType';
            $injectType = $this->annotationReader->getPropertyAnnotation(
                $reflectedProp, $injectAnnotation);

            if ($injectType) {

                if (!$injectType->value) {
                    throw new \RuntimeException(
                        'Inject type is not optional'
                        . 'when used with properties');
                }

                $injectType->setReflectionProperty($reflectedProp);
                $this->typeInjections[$reflectedProp->getName()] = $injectType;
                continue;
            }

            //try inject by name

            $injectAnnotation = 'Core\DependencyInjection\Injections\Inject';
            $inject = $this->annotationReader->getPropertyAnnotation(
                $reflectedProp, $injectAnnotation);

            if ($inject) {

                if (!$inject->value) {
                    $inject->value = $reflectedProp->getName();
                }

                $inject->setReflectionProperty($reflectedProp);
                $this->nameInjections[$reflectedProp->getName()] = $inject;
            }
        }

        $this->injectionsRead = true;
    }

    /**
     * Configures the instance
     * 
     * @return boolean
     */
    public function configureInstance()
    {
        $this->readInjections();

        if ($this->instanceConfigured) {
            return true;
        }

        foreach ($this->typeInjections as $injectType) {
            $reflectionProp = $injectType->getReflectionProperty();
            $subDependency = $this->container->getType(
                $injectType->value, $injectType->mandatory);
            $reflectionProp->setAccessible(true);
            $reflectionProp->setValue($this->instance, $subDependency);
        }
        
        //configure name injections 
        foreach ($this->nameInjections as $inject) {
            $reflectionProp = $inject->getReflectionProperty();
            $subDependency = $this->container->get(
                $inject->value, $inject->mandatory);
            $reflectionProp->setAccessible(true);
            $reflectionProp->setValue($this->instance, $subDependency);
            
        }
       
        $this->instanceConfigured = true;
    }

}