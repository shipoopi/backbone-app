<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Core\Service\Interceptors;

use Core\Util\Pipe\PipeInterface,
    Core\Util\KeyValueStoreInterface,
    Core\Service\ServiceBus;

/**
 * Description of InterceptorPipeAdapter
 *
 * @author hashinpanakkaparambil
 */
class InterceptorPipeAdapter implements PipeInterface
{
    private $interceptor;
    
    public function __construct(InterceptorInterface $interceptor)
    {
        $this->interceptor = $interceptor;
    }
    
    public function flow(KeyValueStoreInterface $bus)
    {
        if (!$bus instanceof ServiceBus) {
            throw new \InvalidArgumentException(
                'Key value store passed must be an instanceof ServiceBus');
        }
        
        if ($bus->isDispatched()) {
            $this->interceptor->postDispatch($bus);
        } else {
            $this->interceptor->preDispatch($bus);
        }
    }
}