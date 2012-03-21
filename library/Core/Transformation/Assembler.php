<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Core\Transformation;

use Core\Transformation\Request;

/**
 * Description of Assembler
 *
 * @author hashinpanakkaparambil
 */
interface Assembler
{
    public function objectFactory();
    public function requestToModel(Request $request, $model);
}