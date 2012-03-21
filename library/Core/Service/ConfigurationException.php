<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Core\Service;

/**
 * Description of ConfigurationException
 *
 * @author hashinpanakkaparambil
 */
class ConfigurationException extends \RuntimeException
{
    const DIRECTORY_NOT_READABLE = 'Directory %s not readable';
}