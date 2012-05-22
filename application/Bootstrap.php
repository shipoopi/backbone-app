<?php

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
        $config->addUrlServiceMapEntry('/users', 'UserService');
        $config->setBaseUrl('/api/index/');
        $controller = Core\Service\FrontControllerFactory::newFrontController($config);
        Zend_Registry::set('serviceController', $controller);
        return $controller;
    }
}

