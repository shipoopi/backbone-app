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
    private $response;

    public function __construct(
    FrontControllerConfig $config, ControllerResolver $controllerResolver)
    {
        $this->config = $config;
        $this->controllerResolver = $controllerResolver;
        $this->includePaths[] = get_include_path();
        $this->addIncludePaths(
            $this->config->getServiceControllerDirectories());
    }

    private function addIncludePaths(array $paths)
    {
        $this->includePaths = $this->includePaths + $paths;
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
        $url .= '/';
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

        $controllerSetting = $this->controllerResolver
            ->resolveServiceController($strippedUrl);

        if (!$controllerSetting) {
            throw new \LogicException('Url is not mapped to a controller');
        }

        $controller = $controllerSetting['service'];
        $methods = $controllerSetting['config']['methods'];
        $method = null;

        //derive parameters
        $url = $controllerSetting['config']['url'];
        preg_match('!^/?' . $url . '/?$!', $strippedUrl, $matches);
        array_shift($matches);
        $params = $controllerSetting['config']['params'];
        $urlParams = array();
        if (count($params) == count($matches)) {
            $urlParams = array_combine($params, $matches);
        }

        $this->request->setParams($urlParams);
        
        $methodKey = 'get';
        if ($this->request->isGet()) {
            $methodKey = 'get';
        } else if ($this->request->isGetCollection()) {
            $methodKey = 'getCollection';
        } else if($this->request->isPost()) {
            $methodKey = 'post';    
        } else if ($this->request->isPut()) {
            $methodKey = 'put';
        } else if ($this->request->isDelete()){
            $methodKey = 'delete';
        } else {
            throw new \LogicException('Invalid method');
        }
        
        if (!isset($methods[$methodKey])) {
            throw new \LogicException(sprintf(
                'Method %s not allowed', $methodKey));    
        }
        
        $method = $methods[$methodKey];
        if (!method_exists($controller, $method)) {
            throw new \LogicException(sprintf(
                'Method %s not found in service %s',
                $method, get_class($controller)));
        }
        
        return $controller->$method($this->request);
    }

}