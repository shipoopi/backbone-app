<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core\Vendor\Zend\Mvc;

use Core\Transformation\ObjectFactoryV2;
use Core\Util\Validator;

/**
 * Description of ActionController
 *
 * @author hashinpanakkaparambil
 */
abstract class ApiControllerAbstract extends \Zend_Rest_Controller
{

    protected $objectFactory;
    protected $autoJsonSerializaton = true;
    private $bodyParams = array();

    public function init()
    {
        $this->objectFactory = new ObjectFactoryV2();
        $this->objectFactory->enableDateTimeConversion('d/m/Y');
        $this->initApiEndPoint();
    }

    public function initApiEndPoint()
    {
        $this->_helper->layout->disableLayout();
        $contextSwitch = $this->_helper->contextSwitch;
        $request = $this->getRequest();
        $request->setParam('format', 'json');
        $contextSwitch->addActionContext($request->getActionName(), 'json')
            ->setAutoJsonSerialization($this->autoJsonSerializaton)
            ->initContext();

        $request = $this->getRequest();
        $contentType = $request->getHeader('Content-Type');
        $rawBody = $request->getRawBody();
        if ($rawBody && strstr($contentType, 'application/json')) {
            $this->setBodyParams(\Zend_Json::decode($rawBody));
        } else {
            $this->setBodyParams($this->getRequest()->getParams());
        }
    }

    public function error($message)
    {
        $this->view->currentErrors[] = $message;
    }

    /**
     * Set body params 
     * 
     * @param  array $params 
     * @return Scrummer_Controller_Action 
     */
    public function setBodyParams(array $params)
    {
        $this->bodyParams = $params;
        return $this;
    }

    /**
     * Retrieve body parameters 
     * 
     * @return array 
     */
    public function getBodyParams()
    {
        return $this->bodyParams;
    }

    /**
     * Get body parameter 
     * 
     * @param  string $name 
     * @return mixed 
     */
    public function getBodyParam($name)
    {
        if ($this->hasBodyParam($name)) {
            return $this->bodyParams[$name];
        }
        return null;
    }

    /**
     * Is the given body parameter set? 
     * 
     * @param  string $name 
     * @return bool 
     */
    public function hasBodyParam($name)
    {
        if (isset($this->bodyParams[$name])) {
            return true;
        }
        return false;
    }

    /**
     * Do we have any body parameters? 
     * 
     * @return bool 
     */
    public function hasBodyParams()
    {
        if (!empty($this->bodyParams)) {
            return true;
        }
        return false;
    }

    /**
     * Get submit parameters 
     * 
     * @return array 
     */
    public function getSubmitParams()
    {
        if ($this->hasBodyParams()) {
            return $this->getBodyParams();
        }
        return $this->getRequest()->getPost();
    }

}