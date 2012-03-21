<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Core\Application;

use Core\Transformation\Request;
use Doctrine\Common\Collections\Collection;
/**
 * Description of Assembler
 *
 * @author hashinpanakkaparambil
 */
interface Service
{
    public function objectFactory();
    public function requestToModel(Request $request, $model);
    public function modelToDto($model, $class);
    public function modelCollectionToDtoCollection(
        Collection $modelollection, $class);
}