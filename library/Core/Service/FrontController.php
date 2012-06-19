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
 * @Configurable
 */
class FrontController
{
    /**
     * @InjectType("Core\DependencyInjection\Container")
     */
    private $container;
    private $config;
    private $includePaths = array();
    private $controllerResolver;
    private $request;
    private $serviceBus;
    private $pipeline;
    private $controllerSetting;
    private $method;
    /**
     *
     * @var type 
     * @Value("${controllerDirs}")
     */
    private $controllerDirs = array();

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

    private function prepareRequestResponse()
    {
        $this->request = new Request();
        $baseUrl = $this->config->getBaseUrl();
        $this->request->setBaseUrl($baseUrl);

        $this->response = new Response();
    }

    private function validateControllerSetting()
    {
        $controllerSetting = $this->controllerSetting;
        if (!$controllerSetting) {
            throw new \LogicException('Url is not mapped to a controller');
        }

        if (!isset($controllerSetting['service'])
            || !isset($controllerSetting['config'])
            || !isset($controllerSetting['config']['methods'])) {
            throw new \LogicException('Invalid configuration');
        }
    }

    private function resolveMethod()
    {

        $controllerSetting = $this->controllerSetting;
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

        $this->method = $method;
    }

    private function createServicePipeline()
    {
        $controllerSetting = $this->controllerSetting;
        $service = ServiceFactory::fromArray($controllerSetting['config']);
        $service->setCallable($controllerSetting['service'], $this->method);
        $this->serviceBus = new ServiceBus($this->request, $this->response);
        $this->serviceBus->setService($service);
        $this->pipeline = new ServicePipeline($service, $this->serviceBus);
    }

    private function resolveController()
    {
        $controllerSetting = $this->controllerResolver
            ->resolveServiceController($this->request->getServiceUrl());
        $this->controllerSetting = $controllerSetting;
        $this->validateControllerSetting($controllerSetting);
    }

    private function registerUrlParamExtractor()
    {
        $controllerSetting = $this->controllerSetting;
        //Url param extractor
        $urlFormat = $controllerSetting['config']['url'];
        $params = array();
        if ($controllerSetting['config']['params']) {
            $params = $controllerSetting['config']['params'];
        }
        $this->pipeline->addInterceptor(
            new Interceptors\UrlParamExtractor($urlFormat, $params));
    }
    
    private function registerContentNegotiator()
    {
        
        $contentNegotiator = new Interceptors\ContentNegotiator();
        $contentNegotiator->registerMediaTypeProvider(
            new Representations\DefaultMediaProvider());
        $contentNegotiator->registerMediaTypeProvider(
            new Representations\JsonProvider());
        $contentNegotiator->registerMediaTypeProvider(
            new Representations\HtmlProvider());

        $this->pipeline->addInterceptor($contentNegotiator);
    }
    
    private function registerDependencyConfigurator()
    {
        $dependencyConfigurator = new Interceptors\DependencyConfigurator($this->container);
        $this->pipeline->addInterceptor($dependencyConfigurator);
    }

    public function run()
    {
        $this->registerIncludePaths();
        $this->prepareRequestResponse();
        $this->resolveController();
        $this->resolveMethod();
        $this->createServicePipeline();
        $this->registerUrlParamExtractor();
        $this->registerDependencyConfigurator();
        $this->registerContentNegotiator();
        $this->pipeline->flow();

        return $this->serviceBus->getResponse();
    }

}