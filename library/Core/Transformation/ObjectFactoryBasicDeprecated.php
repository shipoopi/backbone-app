<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core\Transformation;

use Core\Util\Validator;

/**
 * Description of ObjectFactoryBasic
 *
 * @author hashinpanakkaparambil
 */
class ObjectFactoryBasic implements ObjectFactory
{

    private function isGetter(\ReflectionMethod $method)
    {
        if ($method->getNumberOfRequiredParameters() > 0) {
            return false;
        }
        
        return strpos($method->getName(), 'get') === 0;
    }

    private function methodAccepts(\ReflectionMethod $method, $val)
    {
        if ($method->getNumberOfRequiredParameters() != 1) {
            return false;
        }

        $parameters = $method->getParameters();
        $first = $parameters[0];
        $class = $first->getClass();
        
        $sourceType = 'scalar';
        
        if (is_object($val)) {
            $sourceType =  get_class($val);
        }
        
        if ($class instanceof \ReflectionClass
            && $sourceType != $class->getName()) {
            return false;
        }

        return true;
    }

    public function objectToObject($object, $class)
    {
        Validator::validObject($object);
        Validator::nonEmptyString($class);
        Validator::classExists($class);

        $target = new $class();
        //check the source and copy to the target
        $rObject = new \ReflectionObject($object);
        $sourceMethods = $rObject->getMethods();
        foreach ($sourceMethods as $method) {
            $name = $method->getName();
            //if a getter
            if (strpos($name, 'get') === 0) {

                //check the setter exists
                $setter = 'set' . lcfirst(substr($name, 3));
                if (method_exists($target, $setter)) {
                    $value = $object->$name();
                    $canSet = $this->methodAccepts(
                            new \ReflectionMethod($class, $setter), $value);
                    $canSet = $canSet && (is_scalar($value)
                                          || $value instanceof \DateTime);
                    if ($canSet) {
                        $target->$setter($value);
                    }
                }
            }
        }

        return $target;
    }

    public function requestToObject(
        Request $request, $class, array $skippedProperties = array())
    {
        Validator::nonEmptyString($class);
        Validator::classExists($class);

        $target = new $class();
        foreach ($request->getParams() as $key => $val) {
            //compute setter
            $setter = 'set' . ucfirst($key);
            if (method_exists($target, $setter)) {

                if ($this->methodAccepts(
                        new \ReflectionMethod($class, $setter), $val)) {
                    $target->$setter($val);
                }
            }
        }

        return $target;
    }

    public function objectToArray($object)
    {
        Validator::validObject($object, 'Must be a valid object');
        $rObject = new \ReflectionObject($object);
        $methods = $rObject->getMethods(\ReflectionMethod::IS_PUBLIC);
        $data = array();
        foreach ($methods as $method) {
            if ($this->isGetter($method)) {
                $name = $method->getName();
                $value = $object->$name();
                //only copy scalars
                if (!is_scalar($value)) {
                    continue;
                }
                //value not a scalar
                $key = lcfirst(substr($method->getName(), 3));
                $data[$key] = $value;
            }
        }

        return $data;
    }

    public function updateFromRequest($target, Request $request)
    {
        Validator::validObject($target);

        foreach ($request->getParams() as $key => $val) {
            //compute setter
            $setter = 'set' . ucfirst($key);
            $getter = 'get' . ucfirst($key);
            if (method_exists($target, $setter)
                && method_exists($target, $getter)) {
                $targetVal = $target->$getter();
                if (is_object($targetVal)) {
                    //do not overwrite
                    continue;
                }
                $target->$setter($val);
            }
        }

        return $target;
    }

}
