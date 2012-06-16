<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Core\Service;

use Core\Util\Pipe\Pipeline,
    Core\Service\Interceptors\InterceptorInterface;

/**
 * Description of ServicePipeline
 *
 * @author hashinpanakkaparambil
 */
class ServicePipeline
{
    private $service;
    private $bus;
    private $internalPipeline;
    
    private function getInternalPipeline()
    {
        if (!$this->internalPipeline) {
            $this->internalPipeline = new Pipeline($this->bus);
        }
        
        return $this->internalPipeline;
    }
    
    public function __construct(Service $service, ServiceBus $bus)
    {
        $this->bus = $bus;
        $this->service = $service;
    }
    
    public function addInterceptor(InterceptorInterface $interceptor)
    {
        $this->getInternalPipeline()->addPipe(
            new Interceptors\InterceptorPipeAdapter($interceptor));
        return $this;
    }
    
    public function flow()
    {
        $this->getInternalPipeline()->flow();
        $this->service->flow($this->bus);
        $this->bus->setDispatched(true);
        $this->getInternalPipeline()->flow();
    }
}