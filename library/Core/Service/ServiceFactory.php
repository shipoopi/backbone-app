<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core\Service;

/**
 * Description of ServiceFactory
 *
 * @author hashinpanakkaparambil
 */
class ServiceFactory
{

    public static function fromArray(array $data)
    {
        $isRequiredFieldsSet = isset($data['name'])
            && isset($data['className']) && isset($data['url']);
        if (!$isRequiredFieldsSet) {
            throw new \RuntimeException('Malformed service configuration');
        }

        $service = new Service($data['name'], $data['className'], $data['url']);
        
        return $service;
    }

}