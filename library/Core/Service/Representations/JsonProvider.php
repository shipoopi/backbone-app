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
 * Description of JsonProvider
 *
 * @author hashinpanakkaparambil
 */
class JsonProvider implements MediaTypeProvider
{

    public function getMediaType()
    {
        return 'application/json';
    }

    public function getMediaContent($serviceResult)
    {
        $content = false;
        
        if ($serviceResult instanceof ArrayRepresentable
            || is_array($serviceResult)) {
            $representation = new ArrayJsonRepresentation($serviceResult);
            $content = $representation->getAsString();
        }
        
        return $content;
    }

}