<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core\Service;

/**
 * Description of Response
 *
 * @author hashinpanakkaparambil
 */
class Response
{

    private $body = '';

    public function __construct($body = '')
    {
        $this->setBody($body);
    }

    public function getBody()
    {
        return $this->body;
    }

    public function setBody($body)
    {
        $this->body = (string) $body;
    }
    
    public function __toString()
    {
        return $this->getBody();
    }
}