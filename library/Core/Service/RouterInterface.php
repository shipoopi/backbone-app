<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Core\Service;

/**
 * Description of RouterInterface
 *
 * @author hashinpanakkaparambil
 */
class RouterInterface
{
    /**
     * @return ServiceController
     */
    public function route(Request $request);
}