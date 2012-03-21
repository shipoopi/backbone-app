<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core\Service;

use \PHPUnit_Framework_TestCase as TestCase;

/**
 * Description of ServiceControllerRecognitionTest
 *
 * @author hashinpanakkaparambil
 */
class ServiceControllerRecognitionTest extends TestCase
{

    private $frontController;
    private $config;
    private $controller;
    private $controllerResolver;
    private $serviceControllerDir;

    private function givenFrontController()
    {
        $this->frontController = new FrontController($this->config);
        return $this;
    }

    private function givenServiceControllerDirectory($dir)
    {
        $config = new FrontControllerConfig();
        $config->addServiceControllerDirectory($dir);
        $this->serviceControllerDir = $dir;
        $this->config = $config;
        return $this;
    }

    private function givenConfig()
    {
        $config = new FrontControllerConfig();
        $this->config = $config;
        return $this;
    }

    private function givenRegisteredServiceController($url, $controller)
    {
        $config = $this->config;
        $config->registerServiceController($url, $controller);
        return $this;
    }

    private function givenControllerResolver($controller)
    {
        $this->controllerResolver = new $controller(
                array($this->serviceControllerDir),
                $this->config->getRegisteredServiceControllers());
        return $this;
    }

    private function whenIRequestControllerForUrl($url)
    {
        $this->controller = $this->config->getRegisteredServiceController($url);
        return $this;
    }

    private function whenIResolveControllerForUrl($url)
    {
        $this->controller =
            $this->controllerResolver->resolveServiceController($url);
        return $this;
    }

    private function thenControllerIs($controller)
    {
        $this->assertTrue($controller === $this->controller);
        return $this;
    }

    private function thenControllerIsInstanceOf($class)
    {
        $this->assertInstanceOf($class, $this->controller);
        return $this;
    }

    private function whenICallRun()
    {
        $this->frontController->run();
        return $this;
    }

    private function getServiceControllersAttribute()
    {
        $reflController = new \ReflectionObject($this->frontController);
        $reflControllers = $reflController->getProperty('serviceControllers');
        $reflControllers->setAccessible(true);
        return $reflControllers->getValue($this->frontController);
    }

    private function thenCreatesControllerCache()
    {
        $controllers = $this->getServiceControllersAttribute();
        $this->assertContains('PaymentController', $controllers,
                              'Did not read payment controller');
        return $this;
    }

    /**
     * @expectedException Core\Service\ConfigurationException 
     */
    public function testNoServiceControllerDirectoryConfigurationError()
    {
        $this->givenServiceControllerDirectory('/no/dir');
    }

    public function testValidServiceControllerDirectory()
    {
        $this->givenServiceControllerDirectory('/tmp');
    }

    public function testCanRegisterController()
    {
        $this->givenConfig()
            ->givenRegisteredServiceController('/payments', 'PaymentController')
            ->whenIRequestControllerForUrl('/payments')
            ->thenControllerIs('PaymentController');
    }

    public function testRetrieveNonRegisteredController()
    {
        $this->givenConfig()
            ->whenIRequestControllerForUrl('/payments')
            ->thenControllerIs(null);
    }

    public function testControllerResolverCanResolveController()
    {
        $this->givenServiceControllerDirectory(__DIR__ . '/controllers')
            ->givenRegisteredServiceController('/payments', 'PaymentController')
            ->givenControllerResolver('Core\Service\UrlControllerResolver')
            ->whenIResolveControllerForUrl('/payments')
            ->thenControllerIsInstanceOf('PaymentController');
    }

    public function testResolvingNonMappedController()
    {
        $this->givenServiceControllerDirectory(__DIR__ . '/controllers')
            ->givenControllerResolver('Core\Service\UrlControllerResolver')
            ->whenIResolveControllerForUrl('/payments')
            ->thenControllerIs(null);
    }
    
    public function testRegexResolve()
    {
        $this->givenServiceControllerDirectory(__DIR__ . '/controllers')
            ->givenRegisteredServiceController('/paym.*', 'PaymentController')
            ->givenControllerResolver('Core\Service\UrlControllerResolver')
            ->whenIResolveControllerForUrl('/payments')
            ->thenControllerIsInstanceOf('PaymentController');
    }

}