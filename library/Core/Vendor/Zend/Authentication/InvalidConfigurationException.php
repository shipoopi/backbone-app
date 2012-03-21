<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Core\Vendor\Zend\Authentication;

/**
 * Description of InvalidConfigurationException
 *
 * @author hashinpanakkaparambil
 */
class InvalidConfigurationException extends \Exception
{
    const CONTROLLER_NOT_GIVEN = 'Controller not specified';
    const ACTION_NOT_GIVEN     = 'Action not specified';
    const ADAPTER_NOT_GIVEN    = 'Adapter not specified';
}
