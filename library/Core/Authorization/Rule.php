<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Core\Authorization;

use Core\Transformation\Request;

/**
 *
 * @author hashinpanakkaparambil
 */
interface Rule
{
    public function getRuleName();
    public function isMet(Request $request, Operation $operation);
}