<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CoreServices;

use Core\Service\Service,
    Core\Service\Representations\RepresentationFromFile,
    Core\Service\Representations\ArrayJsonRepresentation,
    Core\Util\Collection;

/**
 * Description of ServiceManagementService
 *
 * @author hashinpanakkaparambil
 */
class ServiceManagementService
{

    public function createService()
    {
        return new ArrayJsonRepresentation(
            new Service('userService', 'UserService', '/users'));
    }

    public function deleteService()
    {
        
    }

    public function getService()
    {
        
    }

    public function updateService()
    {
        
    }

    public function getServices()
    {

        return new ArrayJsonRepresentation(new Collection(array(
                    new Service('userService', 'UserService', '/users', array('get' => 'getUser')),
                    new Service('paymentService', 'PaymentService', '/payments'))));
    }

}