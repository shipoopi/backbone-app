<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use Zend_Application_Resource_ResourceAbstract as ResourceAbstract;
use Core\Vendor\Zend\DependencyInjection\InvalidDefinerException;
use Core\Vendor\Zend\DependencyInjection\Definer;
/**
 * Description of Pimple
 *
 * @author hashinpanakkaparambil
 */
class Core_Vendor_Zend_DependencyInjecton_Resource_Pimple extends ResourceAbstract
{
    public function init()
    {
        $options = $this->getOptions();
        $definerClass = isset($options['definerClass']) ?
                            $options['definerClass']: null;
        
        if (!$definerClass) {
            throw new InvalidDefinerException(
                InvalidDefinerException::DEFINER_CLASS_NOT_GIVEN);
        }
        
        if (!class_exists($definerClass, true)) {
            throw new InvalidDefinerException(sprintf(
                InvalidDefinerException::DEFINER_CLASS_NOT_FOUND, $definerClass));
        }
        
        $definer = new $definerClass();
        
        if (!$definer instanceof Definer) {
            throw new InvalidDefinerException(sprintf(
                InvalidDefinerException::INVALID_DEFINER_INSTANCE,
                $definerClass));
        }
        
        $container = new \Pimple();
        
        $definer->define($container);
        
        //register action helper
        $pimpleHelper = new Core_Vendor_Zend_DependencyInjection_ActionHelper_Pimple();
        Zend_Controller_Action_HelperBroker::addHelper($pimpleHelper);
        
        return $container;
    }
}