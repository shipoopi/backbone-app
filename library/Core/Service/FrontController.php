<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core\Service;

use Core\Service\ControllerResolver;

/**
 * Description of FrontController
 *
 * @author hashinpanakkaparambil
 */
class FrontController
{

    private $serviceControllers = array();
    private $config;
    private $includePaths = array();
    private $controllerResolver;
    private $request;

    public function __construct(
            FrontControllerConfig $config,
            ControllerResolver $controllerResolver)
    {
        $this->config = $config;
        $this->controllerResolver = $controllerResolver;
        $this->includePaths[] = get_include_path();
        $this->addIncludePaths(
            $this->config->getServiceControllerDirectories());
    }

    private function addIncludePaths(array $paths)
    {
        $this->includePaths =  $this->includePaths + $paths;
        return $this;
    }

    private function registerIncludePaths()
    {
        set_include_path(implode(PATH_SEPARATOR, $this->includePaths));
        return $this;
    }
    
    private function prepareRequest()
    {
        $this->request = new Request();
    }

    private function cutOffBaseUrl($url, $baseUrl)
    {
        $url = ltrim($url, '/');
        $url = rtrim($url, '/');
        $baseUrl = ltrim($baseUrl, '/');
        $baseUrl = rtrim($baseUrl, '/');
        return str_replace($baseUrl, '', $url);
    }
    
    public function run()
    {
        $this->registerIncludePaths();
        $this->prepareRequest();
        $url = $this->request->getUrl();
        $baseUrl = $this->config->getBaseUrl();
        $strippedUrl = $this->cutOffBaseUrl($url, $baseUrl);
        
        $controller = $this->controllerResolver
                ->resolveServiceController($strippedUrl);
        if (!$controller) {
            throw new \LogicException('Url is not mapped to a controller');
        }
        
        return $controller->run($this->request);
    }

}