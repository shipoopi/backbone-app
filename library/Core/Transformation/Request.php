<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Core\Transformation;

/**
 * Description of Request
 *
 * @author hashinpanakkaparambil
 */
class Request extends \ArrayObject
{
    public function getParam($param)
    {
        if ($this->offsetExists($param)) {
            return $this[$param];
        }
        
        return null;
    }
    
    public function getParams()
    {
        return (array) $this;
    }
    
    public function setParam($param, $value)
    {
        $this[$param] = $value;
        return $this;
    }
}