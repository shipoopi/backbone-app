<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Core\Util;
/**
 * Description of AccessibleObjectAbstract
 *
 * @author hashinpanakkaparambi
 */
class MagicAccessible
{
    public function __call($name, $arguments)
    {
        $isGetter = strpos($name, 'get') === 0;
        $isSetter = strpos($name, 'set') === 0;
        if (!$isGetter && !$isSetter) {
            throw new RuntimeException('invalid method call');
        }
        
        $propertyName = substr($name, 3);
        
        if (!property_exists($this, $propertyName)) {
            throw new RuntimeException(sprintf(
                'Property %s does not exist', $propertyName));
        }
        
        if ($isGetter) {
            return $this->$propertyName;
        }
        
        if ($isSetter) {
            $this->$propertyName = array_shift($arguments);
            return $this;
        }
    }
}