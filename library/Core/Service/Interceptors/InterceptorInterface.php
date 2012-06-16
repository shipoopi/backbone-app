<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Core\Service\Interceptors;

use Core\Service\ServiceBus;
/**
 *
 * @author hashinpanakkaparambil
 */
interface InterceptorInterface
{
    public function preDispatch(ServiceBus $bus);
    public function postDispatch(ServiceBus $bus);
}