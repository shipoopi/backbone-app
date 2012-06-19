<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Core\Service\Interceptors;

use Core\Service\ServiceBus,
    Core\Util\KeyValueStore;
/**
 * Description of ResourceBootstrapper
 *
 * @author hashinpanakkaparambil
 */
class ResourceBootstrapper extends SelectiveInterceptor
{
    private $resourceProviders;
    
    public function __construct()
    {
        $this->resourceProviders = new KeyValueStore();
    }
    
    public function registerResourceProvider(
        $name, ResourceProviderInterface $provider)
    {
        $this->resourceProviders[$name] = $provider;
    }
    
    public function preDispatch(ServiceBus $bus)
    {
        foreach ($this->resourceProviders as $name => $provider) {
            $bus->setResource($name, $provider);
        }
    }
}