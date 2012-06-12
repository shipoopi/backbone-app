<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use Zend_Form_Element_Text as TextBox,
    Zend_Form_Element_Submit as Submit,
    Zend_Form_Element_Hidden as Hidden;

/**
 * Description of ServicesController
 *
 * @author hashinpanakkaparambil
 */
class Default_ServicesController extends Zend_Controller_Action
{

    private $serviceForm;
    private $serviceMethodForm;
    private $configFile;

    public function init()
    {
        $paths = Zend_Registry::get('configPaths');
        $this->configFile = $paths['services'];

        $this->serviceForm = new Zend_Form();
        $this->view->serviceForm = $this->serviceForm;
        $this->serviceForm->setAction('/services/create')
            ->setMethod('post')
            ->addElement(new TextBox('service', array('label' => 'Service')))
            ->addElement(new TextBox('url', array('label' => 'Url')))
            ->addElement(new TextBox('class', array('label' => 'Class')))
            ->addElement(new Submit('Create', array('class' => 'btn primary')));

        $this->serviceMethodForm = new Zend_Form();
        $this->view->serviceMethodForm = $this->serviceMethodForm;
        $this->serviceMethodForm->setAction('/services/add-method')
            ->setMethod('post')
            ->addElement(new Hidden('url'))
            ->addElement(new TextBox('method', array('label' => 'Method')))
            ->addElement(new TextBox('callback', array('label' => 'Callback')))
            ->addElement(new Submit('Add method', array('class' => 'btn primary')));

        parent::init();
    }

    public function newAction()
    {
        
    }

    public function createAction()
    {
        if ($this->getRequest()->isPost()) {
            if (!$this->serviceForm->isValid($this->getRequest()->getParams())) {
                $this->getResponse()->setHttpResponseCode(400);
            }

            $service = $this->serviceForm->getValues();
            $config = json_decode(file_get_contents($this->configFile), true);
            if (!isset($config['services'])) {
                throw new LogicException('corrupt configuration');
            }

            $config['services'][$service['url']] = $service;

            file_put_contents($this->configFile, json_encode($config));
            $this->view->serviceCreated = true;
            $this->serviceMethodForm->url->setValue($service['url']);
        }

        $this->render('new');
    }

    public function addMethodAction()
    {
        if (!$this->serviceMethodForm->isValid($this->getRequest()->getParams())) {
            $this->getResponse()->setHttpResponseCode(400);
        }

        
        $config = json_decode(file_get_contents($this->configFile), true);
        if (!isset($config['services'])) {
            throw new LogicException('corrupt configuration');
        }

        $url = $this->serviceMethodForm->getValue('url');
        $services = $config['services'];
        if (!isset($services[$url])) {
            throw new LogicException('Service not found');
        }

        $this->serviceForm->populate($config['services'][$url]);
       
        $config['services']
            [$url]['methods']
            [$this->serviceMethodForm->getValue('method')] 
                =   $this->serviceMethodForm->getValue('callback');
        
        file_put_contents($this->configFile, json_encode($config));
        
        $this->view->serviceCreated = true;
        $this->view->methodCreated = true;
        $this->render('new');
    }

}
