<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Description of Authentication
 *
 * @author hashinpanakkaparambil
 */
class Core_Vendor_Zend_Authentication_Plugin_Authentication 
    extends Zend_Controller_Plugin_Abstract
{
    private $options = array(
        'module'        => '',
        'controller'    => 'index',
        'action'        => 'login',
        'excludes'      => array()
    );
    
    public function setOptions(array $options)
    {
        $this->options = array_merge($this->options,$options);
    }
    
    public function dispatchLoopStartup(
        Zend_Controller_Request_Abstract $request)
    {
        //check if an excluded request
        
        foreach ($this->options['excludes'] as $exclude) {
            $current    = $request->getModuleName() . '-' 
                        .  $request->getControllerName(). '-' 
                        . $request->getActionName();
            
            if (strtolower($exclude) == strtolower($current)) {
                return false;
            }
        }
        
        if (!\Zend_Auth::getInstance()->hasIdentity()) {
            
            if ($this->options['module']) {
                $request->setModuleName('module');
            }
            
            $request->setControllerName($this->options['controller']);
            $request->setActionName($this->options['action']);
        }
    }
}
