<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Core\Vendor\Zend\DependencyInjection;

/**
 * Description of InvalidDefinerException
 *
 * @author hashinpanakkaparambil
 */
class InvalidDefinerException extends \Exception
{
    const DEFINER_CLASS_NOT_GIVEN  = 'Definer class not specified';
    const DEFINER_CLASS_NOT_FOUND  = 'Definer class %s not found';
    const INVALID_DEFINER_INSTANCE = 'Definer class %s must implement interface "Core\Vendor\Zend\DependencyInjection\Definer"';
}