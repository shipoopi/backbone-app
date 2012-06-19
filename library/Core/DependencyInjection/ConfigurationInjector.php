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
 * Description of ConfigurationInjector
 *
 * @author hashinpanakkaparambil
 */
class ConfigurationInjector
{

    private $valueInjections = array();
    private $reflectedProperties = array();
    private $injectionsRead = array();
    private $annotationReader;
    private $valueResolver;

    public function __construct(ValueResolver $resolver)
    {
        $currentDirectory = dirname(__FILE__);
        AnnotationRegistry::registerFile(
            $currentDirectory . '/Injections/DoctrineAnnotations.php');
        $this->annotationReader = new AnnotationReader();
        $this->valueResolver = $resolver;
    }

    private function readInjections($instance)
    {

        $type = get_class($instance);
        if (isset($this->injectionsRead[$type])
            && $this->injectionsRead[$type] == true) {
            if (!isset($this->valueInjections[$type])) {
                throw \LogicException(
                    'Injections marked as read, but no injections present');
            }

            return $this->valueInjections[$type];
        }

        $props = array();
        if (isset($this->reflectedProperties[$type])) {
            $props = $this->reflectedProperties[$type];
        } else {
            $reflectionClass = new \ReflectionClass($instance);
            $props = $this->reflectedProperties[$type] =
                $reflectionClass->getProperties();
        }
        
        $this->valueInjections[$type] = array();

        foreach ($props as $property) {
            $valueAnnotationKey = 'Core\DependencyInjection\Injections\Value';
            $valueAnnotation = $this->annotationReader->getPropertyAnnotation(
                $property, $valueAnnotationKey);
           
            if ($valueAnnotation) {
                $valueAnnotation->setReflectionProperty($property);
                $this->valueInjections[$type][] = $valueAnnotation;
            }

           
        }

        $this->injectionsRead[$type] = true;
        
        return $this->valueInjections[$type];
    }

    public function inject($instance, array $configuration)
    {

        if (!is_object($instance)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Instance passed should be a valid object, %s given',
                    gettype($instance)));
        }

        $confAnnotationKey = 'Core\DependencyInjection\Injections\Configurable';
        $reflClass = new \ReflectionClass($instance);
        $configurable = $this->annotationReader
            ->getClassAnnotation($reflClass, $confAnnotationKey);
     
        if (!$configurable && !empty($configuration)) {
             throw new \LogicException(sprintf(
                '%s is not configurable', get_class($instance)));
        }

        $injections = $this->readInjections($instance);

        foreach ($injections as $valueAnnotation) {
            
            $valueKey = trim($valueAnnotation->value);
            if (isset($configuration[$valueKey])) {

                $value = $configuration[$valueKey];
                $value = $this->valueResolver->resolve($value);
                $property = $valueAnnotation->getReflectionProperty();
                $property->setAccessible(true);
                $property->setValue($instance, $value);
            } else if ($valueAnnotation->mandatory) {
                throw new \LogicException(sprintf(
                    'Value %s is mandatory for %s',
                    $valueKey, get_class($instance)));
            }
        }
    }

}