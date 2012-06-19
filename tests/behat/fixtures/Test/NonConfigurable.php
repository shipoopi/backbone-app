<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Test;

use Core\DependencyInjection\Injections;

/**
 * Description of UserService
 *
 * @author hashinpanakkaparambil
 */
class NonConfigurable
{
    /**
     * @Injections\Value("${host}")
     * @var type 
     */
    private $host;
}