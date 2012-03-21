<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Core\Vendor\Zend\Mvc;

/**
 *
 * @author hashinpanakkaparambil
 */
interface ActionController
{
    public function populateForm(\Zend_Form $form, $obect);
}