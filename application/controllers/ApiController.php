<?php

class Default_ApiController extends Zend_Controller_Action
{

    public function indexAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $application = Zend_Registry::get('application');
        var_dump($application);die;
//        $serviceController = Zend_Registry::get('serviceController');
//        $this->getResponse()->appendBody($serviceController->run());
    }

}