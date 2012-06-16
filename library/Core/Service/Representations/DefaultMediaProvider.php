<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core\Service\Representations;

/**
 * Description of DefaultMediaProvider
 *
 * @author hashinpanakkaparambil
 */
class DefaultMediaProvider implements MediaTypeProvider
{

    private $default = 'Core\Service\Representations\JsonProvider';
    
    public function __construct(
        $default = 'Core\Service\Representations\JsonProvider')
    {
        $this->default = $default;
    }
    
    public function getMediaContent($serviceResult)
    {
        $provider = new $this->default();
        return $provider->getMediaContent($serviceResult);
    }

    public function getMediaType()
    {
        return '*/*';
    }

}