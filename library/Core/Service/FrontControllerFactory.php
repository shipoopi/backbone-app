<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Core\Service;

/**
 * Description of FrontControllerFactory
 *
 * @author hash
 */
class FrontControllerFactory
{
    public static function newFrontController(
            FrontControllerConfig $frontControllerConfig)
    {
        $urlServiceMap = $frontControllerConfig->getUrlServiceMap();
        $controllerDirs = $frontControllerConfig->getServiceControllerDirectories();
        $controllerResolver = new UrlControllerResolver(
                $controllerDirs, $urlServiceMap);
        $serviceController = new FrontController(
                $frontControllerConfig, $controllerResolver);
        return $serviceController;
    }
}