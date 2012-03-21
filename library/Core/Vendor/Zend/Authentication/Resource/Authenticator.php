<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use Zend_Application_Resource_ResourceAbstract as ResourceAbstract;
use Core\Vendor\Zend\Authentication\InvalidConfigurationException;

/**
 * Description of Pimple
 *
 * @author hashinpanakkaparambil
 */
class Core_Vendor_Zend_DependencyInjecton_Resource_Authenticator extends ResourceAbstract
{
    public function init()
    {
        $options = $this->getOptions();
        
        $module     = isset($options['module']) ? $options['module'] : null;
        $controller = isset($options['controller']) ? 
                        $options['controller'] : null;
        $action     = isset($options['action']) ? $options['action'] : null;
        
        $exclude    = isset($options['exclude']) ? $options['exclude']: '';
        $excludes   = explode(',', $exclude);
        
        if (!$controller) {
            throw new InvalidConfigurationException(
                InvalidConfigurationException::CONTROLLER_NOT_GIVEN);
        }
        
        if (!$action) {
            
            throw new InvalidConfigurationException(
                InvalidConfigurationException::ACTION_NOT_GIVEN);
        }
        
        //register authentication plugin
        
        $plugin = new Core_Vendor_Zend_Authentication_Plugin_Authentication();
        $plugin->setOptions(array(
            'module'        => $module,
            'controller'    => $controller,
            'action'        => $action,
            'excludes'      => $excludes));
        
        
        $front  = Zend_Controller_Front::getInstance();
        $front->registerPlugin($plugin);
        
        return $options;
    }
}