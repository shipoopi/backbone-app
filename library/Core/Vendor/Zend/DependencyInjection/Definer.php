<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Core\Vendor\Zend\DependencyInjection;

/**
 *
 * @author hashinpanakkaparambil
 */
interface Definer
{
    public function define(\Pimple $pimple);
}