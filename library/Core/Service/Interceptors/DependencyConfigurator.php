<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Core\Service\Interceptors;

use Core\DependencyInjection\Container,
    Core\Service\ServiceBus;

/**
 * Description of DependencyConfigurator
 *
 * @author hashinpanakkaparambil
 */
class DependencyConfigurator extends SelectiveInterceptor
{
    private $container;
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function postDispatch(ServiceBus $bus)
    {
        die('configuring');
        $service = $bus->get('service');
        $this->container->configure($service);
    }

}