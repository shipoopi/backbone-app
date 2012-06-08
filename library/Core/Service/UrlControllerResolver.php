<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core\Service;

/**
 * Description of AutoloadControllerResolver
 *
 * @author hashinpanakkaparambil
 */
class UrlControllerResolver implements ControllerResolver
{

    private $controllerDirs = array();
    private $urlServiceMap = array();
    private $resolvedControllers = array();

    public function __construct(
        array $controllerDirs, array $urlServiceMap)
    {
        $this->controllerDirs = $controllerDirs;
        $includePaths = $controllerDirs;
        $includePaths[] = get_include_path();
        
        set_include_path(implode(PATH_SEPARATOR, $includePaths));
        $this->urlServiceMap = $urlServiceMap;
    }

    public function newInstance($class)
    {
        $prototype = unserialize(sprintf('O:%d:"%s":0:{}', strlen($class),
                                                                  $class));

        return clone $prototype;
    }

    public function resolveServiceController($url)
    {
        if (isset($this->resolvedControllers[$url])) {
            return $this->resolvedControllers[$url];
        }
        
        foreach ($this->urlServiceMap as $mappedUrl => $controller) {
            
            if (preg_match('!^(' . $mappedUrl . '/?$)!', $url, $matches)) {
                
                $this->resolvedControllers[$matches[1]]['service'] =
                    $this->newInstance($controller['class']);
                $this->resolvedControllers[$matches[1]]['config'] = $controller; 
                
                return $this->resolvedControllers[$matches[1]];
            }
        }
      
        
        return null;
    }

}