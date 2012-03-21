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
 * Description of ObjectFactory
 *
 * @author hashinpanakkaparambil
 */
interface ObjectFactory
{
    public function newInstance($class);
        
    public function objectToObject(
        $object, $class, array $skippedProperties = array());

    public function requestToObject(
        Request $request, $class, array $skippedProperties = array());

    public function updateObject(
        $source, $target, array $skippedProperties = array());

    public function objectToArray(
        $object, array $skippedProperties = array());

    public function updateFromRequest(
        $target, Request $request, array $skippedProperties = array());

    public function arrayToObject(
        array $values, $classOrObject, array $skippedProperties = array());
}