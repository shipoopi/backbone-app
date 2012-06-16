<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Core\Service\Representations;

/**
 * Description of XmlProvider
 *
 * @author hashinpanakkaparambil
 */
class HtmlProvider implements MediaTypeProvider
{

    public function getMediaType()
    {
        return 'text/html';
    }

    public function getMediaContent($serviceResult)
    {
        return '<p/>';
    }
}