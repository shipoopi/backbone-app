<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Core\Application;

/**
 *
 * @author hashinpanakkaparambil
 */
interface ApplicationAware
{
    public function setApplication(Application $app);
    public function getApplication();
}