<?php

namespace Core\Transformation;

use Core\Util\Validator;

/**
 * Description of ObjectFactoryV2
 *
 * @author hashinpanakkaparambil
 */
class ObjectFactoryV2 implements ObjectFactory
{

    /**
     * Holds the conversion format 
     * @var string
     */
    private $dateTimeConversionFormat;

    /**
     * Creates an object without calling its constructor
     * uses serialization
     * @param string $class
     * @return mixed an instance of given class
     */
    public function newInstance($class)
    {
        $prototype = unserialize(sprintf('O:%d:"%s":0:{}', strlen($class),
                                                                  $class));

        return clone $prototype;
    }

    /**
     * Determines if a method is a getter that can be used to copy
     * values form an object
     * 
     * @param \ReflectionMethod $method
     * @return type 
     */
    private function isGetter(\ReflectionMethod $method)
    {
        return strpos($method->getName(), 'get') === 0
            || strpos($method->getName(), 'is') === 0
            || strpos($method->getName(), 'has') === 0;
    }

    /**
     * Creates the property name from a method
     * 
     * @param \ReflectionMethod $method
     * @return string
     */
    private function propertyFromMethod(\ReflectionMethod $method)
    {
        $property = '';

        if (strpos($method->getName(), 'get') === 0
            || strpos($method->getName(), 'has') === 0) {

            $property = lcfirst(substr($method->getName(), 3));
        } else if (strpos($method->getName(), 'is') === 0) {
            $property = lcfirst(substr($method->getName(), 2));
        }

        return $property;
    }

    /**
     * Creates an instance of the given class using the properties from 
     * the given object
     * 
     * @param type $object
     * @param type $class
     * @param array $skippedProperties proprties not to be copied
     * @return type
     */
    public function objectToObject(
    $object, $class, array $skippedProperties = array())
    {
        Validator::validObject($object);
        Validator::nonEmptyString($class);
        Validator::classExists($class);

        //inspect the source

        $target = $this->newInstance($class);

        $this->updateObject($object, $target, $skippedProperties);

        return $target;
    }

    /**
     * Functions similar to objectToObject but the source is a request 
     * 
     * @param Request $request
     * @param type $class
     * @param array $skippedProperties
     * @return type 
     */
    public function requestToObject(
    Request $request, $class, array $skippedProperties = array())
    {
        if ($request->count() == 0) {
            return false;
        }
        
        return $this->arrayToObject(
                $request->getParams(), $class, $skippedProperties);
    }

    /**
     * Given source and target, both objects, 
     * copies properties from the source to target excluding skippedProperties
     * 
     * @param type $source
     * @param type $target
     * @param array $skippedProperties
     * @return mixed target type
     */
    public function updateObject($source, $target,
                                 array $skippedProperties = array())
    {

        $arrayData = $this->objectToArray($source, $skippedProperties);
        if (empty($arrayData)) {
            return false;
        }
        $this->arrayToObject($arrayData, $target, $skippedProperties);
        return $target;
    }

    /**
     * Converts an object to an array using the getters in the object.
     * Properties in skippedProperties array, if given, are not copies
     * 
     * @param type $object
     * @param array $skippedProperties
     * @return array
     */
    public function objectToArray($object, array $skippedProperties = array())
    {
        Validator::validObject($object, 'Must be a valid object');
        $rObject = new \ReflectionObject($object);
        $methods = $rObject->getMethods(\ReflectionMethod::IS_PUBLIC);
        $data = array();
        foreach ($methods as $method) {
            $key = $this->propertyFromMethod($method);
            if (!in_array($key, $skippedProperties)
                && $this->isGetter($method)) {
                $name = $method->getName();
                $value = $object->$name();
                if (!isset($value)) {
                    continue;
                }

                //value not a scalar

                if ($value instanceof \DateTime
                    && is_string($this->dateTimeConversionFormat)) {
                    $value = $value->format($this->dateTimeConversionFormat);
                } else if (is_object($value) && !$value instanceof \DateTime) {
                    $toSkipForSubObject = array();
                    if (isset($skippedProperties[$key])) {
                        $toSkipForSubObject = $skippedProperties[$key];
                    }

                    $value = $this->objectToArray($value, $toSkipForSubObject);
                }

                $data[$key] = $value;
            }
        }

        return $data;
    }

    /**
     * Functions similar to arrayToObject except the source is a request
     * 
     * @param type $target
     * @param Request $request
     * @param array $skippedProperties
     * @return type 
     */
    public function updateFromRequest($target, Request $request,
                                      array $skippedProperties = array())
    {
        return $this->arrayToObject(
                $request->getParams(), $target, $skippedProperties);
    }

    /**
     * Enables date time conversion given the conversion format
     * 
     * @param type $format
     * @return \Everlution\Infrastructure\Transformation\ObjectFactoryV2 
     */
    public function enableDateTimeConversion($format)
    {
        $this->dateTimeConversionFormat = $format;
        return $this;
    }

    /**
     * Converts $values array to object
     * An skippedProperties are not copied from the array to the target object
     * Second paramter can be either a class name or an existing object
     * For the values to be copied correctly this function expects that the
     * target object has a setter defined for each keys in the values array
     * 
     * @param array $values
     * @param type $classOrObject
     * @param array $skippedProperties
     * @return mixed
     * @throws \InvalidArgumentException
     * @throws Exception 
     */
    public function arrayToObject(array $values, $classOrObject,
                                  array $skippedProperties = array())
    {
        if (count($values) == 0) {
            throw new \InvalidArgumentException('Values array is empty');
        }

        $mappedObject = null;

        if (is_string($classOrObject)) {
            Validator::classExists($classOrObject,
                                   sprintf(
                    'Class %s not found', $classOrObject));
            $mappedObject = $this->newInstance($classOrObject);
        } else {
            $mappedObject = $classOrObject;
        }


        foreach ($values as $prop => $val) {
            if (!is_string($prop)) {
                throw new \InvalidArgumentException(
                    'Invalid property %s in values array', $prop);
            }

            if (in_array($prop, $skippedProperties)) {
                continue;
            }

            //compute the setter
            $setter = 'set' . ucfirst($prop);

            //read the type hint
            //if the setter exists
            if (method_exists($mappedObject, $setter)) {


                $reflectedSetter = new \ReflectionMethod($mappedObject, $setter);
                $parameterCount = $reflectedSetter
                    ->getNumberOfRequiredParameters();

                if ($parameterCount > 1) {
                    throw new \LogicException(sprintf(
                            'Setter can have only 1 required parameter, got %s',
                            $parameterCount));
                }

                $typeHint = null;

                foreach ($reflectedSetter->getParameters() as $reflParam) {
                    if ($reflParam->getClass()) {
                        $typeHint = $reflParam->getClass()->getName();
                    }
                }

                if ($typeHint == 'DateTime'
                    && !is_string($this->dateTimeConversionFormat)) {

                    throw new \InvalidArgumentException(sprintf(
                            'Got date time to be mapped %s, 
                       but conversion format is not set',
                            $prop));
                } else if ($typeHint == 'DateTime'
                    && is_string($this->dateTimeConversionFormat)) {

                    $dateVal = \DateTime::createFromFormat(
                            $this->dateTimeConversionFormat, $val);

                    if ($dateVal instanceof \DateTime
                        && $dateVal->format($this->dateTimeConversionFormat)
                        == $val) {
                        $val = $dateVal;
                    }
                } else if ($typeHint
                    && is_array($val)) {

                    $val = $this->arrayToObject($val, $typeHint);
                } else if ($typeHint) {

                    throw new \InvalidArgumentException(sprintf(
                            'Setter for this array key %s is type hinted,
                            expecting array, got %s',
                            $prop, gettype($val)));
                }

                $mappedObject->$setter($val);
            }
        }

        return $mappedObject;
    }

    public function registerToArrayCallback(
        $type, \Closure $toArray)
    {
        
    }

    public function registertoObjectCallback(
        $key, \Closure $toObject)
    {
        
    }

    public function resetCallbacks()
    {
        
    }

}