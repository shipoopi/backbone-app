<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Core\Service\Representations;

use Core\Util\Collection;

/**
 * Description of HtmlReflectionRepresentation
 *
 * @author hashinpanakkaparambil
 */
class HtmlRepresentation implements RepresentationInterface
{
    private $representable;
    private $strategy = 'HtmlObjectReflection';
    
    public function __construct(
        $representable, $strategy = 'HtmlObjectReflection')
    {
        $this->strategy = $strategy;
        $this->representable = $representable;
    }

    public function getAsString()
    {
        
    }
    
    
    
}
