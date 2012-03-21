<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use Zend_View_Helper_Abstract as HelperAbstract;

/**
 * Description of UnityUrl
 *
 * @author hashinpanakkaparambil
 */
class View_Helper_Errors extends HelperAbstract
{
    public function errors($errors)
    {
        $html = '';
        if (is_array($errors) && count($errors) > 0) {
            foreach ($errors as $error) {   
                $html .= "<span>
{$this->view->escape($error)}</span><br/>" ;

            }
            $html = "<div class='errors''>$html</div>";
        }
        
        return $html;
    }
}