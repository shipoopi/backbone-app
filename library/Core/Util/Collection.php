<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Core\Util;

use Core\Util\ArrayRepresentable;


/**
 * Description of ArrayRepresentableCollection
 *
 * @author hashinpanakkaparambil
 */
class Collection extends \ArrayObject
    implements ArrayRepresentable
{
    
    public function toArray()
    {
        $data = array();
        
        foreach ($this as $item) {
            if ($item instanceof ArrayRepresentable) {
                $data[] = $item->toArray();
            } else {
                throw \LogicExeption('Item is not an array representable');
            }
        }
        
        return $data;
    }
}