<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Core\Service;

/**
 * Description of FrontControllerConfig
 *
 * @author hashinpanakkaparambil
 */
class FrontControllerConfig
{
    private $serviceControllerDirs = array();
    private $serviceControllers = array();
    private $urlServiceMap = array();
    private $baseUrl = '';
    
    public function addServiceControllerDirectory($dir)
    {
        $dir = (string) $dir;
        if (!is_readable($dir)) {
            throw new ConfigurationException(sprintf(
                ConfigurationException::DIRECTORY_NOT_READABLE, $dir));
        }
        $this->serviceControllerDirs[] = $dir;
        return $this;
    }
    
    public function getServiceControllerDirectories()
    {
        return $this->serviceControllerDirs;
    }
    
    public function setServiceControllerDirectories(array $dirs)
    {
        foreach ($dirs as $dir) {
            $this->addServiceControllerDirectory($dir);
        }
    }
    
    public function registerServiceController($url, $controller)
    {
        $url = (string) $url;
        $controller = (string) $controller;
        $this->serviceControllers[$url] = $controller;
        return $this;
    }
    
    public function getRegisteredServiceController($url)
    {
        $url = (string) $url;
        $controller = null;
        if (isset($this->serviceControllers[$url])) {
            $controller = $this->serviceControllers[$url];
        }
        
        return $controller;
    }
    
    public function getRegisteredServiceControllers()
    {
        return $this->serviceControllers;
    }
    
    public function getUrlServiceMap()
    {
        return $this->urlServiceMap;
    }
    
    public function setUrlServicMap(array $map)
    {
        $this->urlServiceMap = $map;
        return $this;
    }
    
    public function addUrlServiceMapEntry($url, $service)
    {
        $this->urlServiceMap[(string)$url] = ($service);
        return $this;
    }
    
    public function setBaseUrl($url)
    {
        $this->baseUrl = (string) $url;
        return $this;
    }
    
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }
}