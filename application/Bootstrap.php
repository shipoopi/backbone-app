<?php

use Core\DependencyInjection\Container;

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    public function _initRestRoutes()
    {
        $front = Zend_Controller_Front::getInstance();
        $restRoute = new Zend_Rest_Route($front, array(), array('api'));
        $front->getRouter()->addRoute('rest', $restRoute);
    }

    public function _initServices()
    {
        $config = new \Core\Service\FrontControllerConfig();
        $config->addServiceControllerDirectory(APPLICATION_PATH . '/services');
     
        $configFile = APPLICATION_PATH . '/repository/services.json';
        $services   = json_decode(file_get_contents($configFile), true);

        if (!isset($services)) {
            throw new LogicException('services not defined');
        }
        
        foreach ($services['services'] as $url => $serviceConfig) {
            $config->setServiceConfig($url, $serviceConfig);
        }
        
        $config->setBaseUrl('/api/index/');
        $controller = Core\Service\FrontControllerFactory::newFrontController($config);
        Zend_Registry::set('serviceController', $controller);
        return $controller;
        
    }
    
    public function _initServiceApp()
    {
        $dependenciesFile = APPLICATION_PATH . '/configs/application.json';
        $application = new Container(json_decode(file_get_contents($dependenciesFile), true));
        Zend_Registry::set('application', $application);
    }

    public function _initPaths()
    {
        $paths = array(
            'services' => APPLICATION_PATH . '/repository/services.json');
        Zend_Registry::set('configPaths', $paths);
    }
}