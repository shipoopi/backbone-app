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
class ArrayJsonRepresentation implements RepresentationInterface,
    MediaTypeProvider
{

    private $representable = array();
    private $root;

    public function __construct($representable, $root = null)
    {
        $this->representable = $representable;
        $this->root = $root;
    }

    public function getAsString()
    {
        $data = array();
        if (is_array($this->representable)) {
            $data = $this->representable;
        } else if ($this->representable instanceof ArrayRepresentable) {
            $data = $this->representable->toArray();
        } else {
            throw new \UnexpectedValueException(sprintf(
                'Representable has to be an array or 
                    instance of ArrayRepresentable'));
        }

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
