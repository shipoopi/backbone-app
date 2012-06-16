<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Core\Service\Interceptors;

use Core\Service\ServiceBus,
    Core\Service\Representations\MediaTypeProvider,
    Core\Util\KeyValueStore,
    Core\Service\Representations\RepresentationInterface;

/**
 * Description of ContentNegotiator
 *
 * @author hashinpanakkaparambil
 */
class ContentNegotiator extends SelectiveInterceptor
{
    private $mediaProviders;
    
    public function __construct()
    {
        $this->mediaProviders = new KeyValueStore();
    }
    public function registerMediaTypeProvider(MediaTypeProvider $provider)
    {
        $this->mediaProviders->set($provider->getMediaType(), $provider);
        return $provider;
    }
    
    public function preDispatch(ServiceBus $bus)
    {
        //parse request body
    }
    
    public function postDispatch(ServiceBus $bus)
    {
        $request = $bus->getRequest();
        $accept = $request->getAccept();
        
        $provider = $this->mediaProviders->get($accept);
        if (!$provider) {
            throw new \LogicException('Media can not be served');
        }
        $response = $bus->getResponse();
        $body = $provider->getMediaContent($bus->get('serviceResult'));
        $mediaType = $accept;
        
        //try representation
        if (!$body) {
            $serviceResult = $bus->get('serviceResult');
            
            if ($serviceResult instanceof RepresentationInterface) {
                $body = $serviceResult->getAsString();
                if ($serviceResult instanceof MediaTypeProvider) {
                    $mediaType = $serviceResult->getMediaType();
                }
            }
        }
        
        $response->setBody($body);
        header('Content-Type: ' . $mediaType);
    }
    
}
