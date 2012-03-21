<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use Zend_Controller_Action_Helper_Abstract as HelperAbstract;

use Core\Util\Validator;

/**
 * Description of Pimple
 *
 * @author hashinpanakkaparambil
 */
class Core_Vendor_Zend_DependencyInjection_ActionHelper_Pimple
    extends HelperAbstract
{
    public function direct($dependency)
    {
        Validator::nonEmptyString($dependency);
        
        $pimple = $this->getActionController()->getInvokeArg('bootstrap')
            ->getResource('pimple');
        
        if (!$pimple instanceof \Pimple) {
            throw new \UnexpectedValueException(
                'Valid pimple container expected');
        }
        
        return $pimple[$dependency];
        
    }
}