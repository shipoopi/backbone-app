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
        $isRequiredFieldsSet = isset($data['service'])
            && isset($data['className']) && isset($data['url']);
        if (!$isRequiredFieldsSet) {
            throw new \RuntimeException('Malformed service configuration');
        }

        $service = new Service($data['service'], $data['className'], $data['url']);
        if (isset($data['methods'])) {
            $service->setMethods($data['methods']);
        }
        
        return $service;
    }

}