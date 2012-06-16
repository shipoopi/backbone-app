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
    Core\Util\Collection,
    Core\Service\Request,
    Core\Service\ServiceRepositories\FileServiceRepository;

/**
 * Description of ServiceManagementService
 *
 * @author hashinpanakkaparambil
 */
class ServiceManagementService
{
    
    public function createService(Request $request)
    {
        $url = $request->get('url');
        $name = $request->get('name');
        $class = $request->get('class');
        $service = new Service($name, $class, $url);
        $file = APPLICATION_PATH . '/repository/app-services.json';
        $serviceRepository = new FileServiceRepository($file);
        $serviceRepository->save($service);
        return new ArrayJsonRepresentation($service);
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

        return array(
                    new Service('userService', 'UserService', '/users', array('get' => 'getUser')),
                    new Service('paymentService', 'PaymentService', '/payments'));
    }

}