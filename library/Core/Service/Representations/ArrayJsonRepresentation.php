<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core\Service\Representations;

use Core\Util\ArrayRepresentable;

/**
 * Description of ArrayJsonRepresentation
 *
 * @author hashinpanakkaparambil
 */
class ArrayJsonRepresentation implements RepresentationInterface
{

    private $representable = array();
    private $root;

    private function getDataArray($representable)
    {
        $data = array();
        $iterableData = array();
        if (is_array($representable)) {
            $iterableData = $representable;
        } else if ($representable instanceof ArrayRepresentable) {
            $iterableData = $representable->toArray();
        }
        
        if (!empty($iterableData)) {
            foreach ($iterableData as $key => $val) {
                if (is_array($val) || $val instanceof ArrayRepresentable) {
                    $data[$key] = $this->getDataArray($val); 
                } else {
                    $data[$key] = $val;
                }
            }
        }
        
        return $data;
    }
    
    public function __construct($representable, $root = null)
    {
        $this->representable = $representable;
        $this->root = $root;
    }

    public function getAsString()
    {
        $data = $this->getDataArray($this->representable);
        if (is_string($this->root)) {
            return json_encode(array($this->root => $data));
        } else {
            return json_encode($data);
        }
    }

    public function __toString()
    {
        return $this->getAsString();
    }

    public function getMediaType()
    {
        return 'application/json';
    }

}
