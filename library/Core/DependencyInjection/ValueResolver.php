<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Core\DependencyInjection;

/**
 * Description of ValueResolver
 *
 * @author hashinpanakkaparambil
 */
class ValueResolver
{
    private $container;
    
    public function __construct(Container $container)
    {
        $this->container = $container;
    }
    
    public function resolve($val)
    {
        if (!is_string($val)) {
            return $val;
        }
        
        $resolvedValue = trim((string) $val);
        
        if (strpos($val, '@') === 0) {
            $resolvedValue = $this->container->get(ltrim($val, '@'));
        }
        
        return $resolvedValue;
    }
    
}