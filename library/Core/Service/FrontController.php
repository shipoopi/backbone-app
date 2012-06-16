<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core\Service;

use Core\Service\ControllerResolver,
    Core\Util\KeyValueStore,
    Core\Util\Pipe\Pipeline,
    Core\Util\Pipe\PipeInterface;
    

/**
 * Description of FrontController
 *
 * @author hashinpanakkaparambil
 */
class FrontController
{

    private $config;
    private $includePaths = array();
    private $controllerResolver;
    private $request;

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
        $baseUrl = $this->config->getBaseUrl();
        $this->request->setBaseUrl($baseUrl);
    }

    

    public function run()
    {
        $this->registerIncludePaths();
        $this->prepareRequest();
        $url = $this->request->getUrl();
        
        $controllerSetting = $this->controllerResolver
            ->resolveServiceController($this->request->getServiceUrl());
        
        if (!$controllerSetting) {
            throw new \LogicException('Url is not mapped to a controller');
        }

        if (!isset($controllerSetting['service'])
            || !isset($controllerSetting['config'])
            || !isset($controllerSetting['config']['methods'])) {
            throw new \LogicException('Invalid configuration');
        }

        $controller = $controllerSetting['service'];
        $methods = $controllerSetting['config']['methods'];
        $method = null;

        $methodKey = 'get';
        if ($this->request->isGet()) {
            $methodKey = 'get';
        } else if ($this->request->isGetCollection()) {
            $methodKey = 'getCollection';
        } else if ($this->request->isPost()) {
            $methodKey = 'post';
        } else if ($this->request->isPut()) {
            $methodKey = 'put';
        } else if ($this->request->isDelete()) {
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
                    'Method %s not found in service %s', $method,
                    get_class($controller)));
        }

        $serviceName = '';
        if (isset($controllerSetting['config']['service'])) {
            $serviceName = $controllerSetting['config']['service'];
        }
        
        $service = new Service(
            $serviceName,  $url, $methods,
            $controllerSetting['config']['className']);
        
        $service->setCallable($controller, $method);
        $this->response = new Response();
        
        $serviceBus = new ServiceBus($this->request, $this->response);        
        $pipeLine = new ServicePipeline($service, $serviceBus);
        
        //Url param extractor
        $urlFormat = $controllerSetting['config']['url'];
        $params    = array();
        if ($controllerSetting['config']['params']) {
            $params = $controllerSetting['config']['params'];
        }
        
        $contentNegotiator = new Interceptors\ContentNegotiator();
        $contentNegotiator->registerMediaTypeProvider(new Representations\DefaultMediaProvider());
        $contentNegotiator->registerMediaTypeProvider(new Representations\JsonProvider());
        $contentNegotiator->registerMediaTypeProvider(new Representations\HtmlProvider());
        
        $pipeLine->addInterceptor(
            new Interceptors\UrlParamExtractor($urlFormat, $params));
        $pipeLine->addInterceptor($contentNegotiator);
        
        $pipeLine->flow();
        
        $representation = $serviceBus->get('serviceResult');
        
        return $serviceBus->getResponse();
    }

}