<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core\Service\Interceptors;

use Core\Service\ServiceBus;

/**
 * Description of UrlParamExtractor
 *
 * @author hashinpanakkaparambil
 */
class UrlParamExtractor extends SelectiveInterceptor
{

    private $urlFormat = '';
    private $params = array();

    public function __construct($urlFormat, array $params)
    {
        $this->urlFormat = (string) $urlFormat;
        $this->params = $params;
    }

    public function preDispatch(ServiceBus $bus)
    {
        $request = $bus->getRequest();
        $serviceUrl = $request->getServiceUrl();
        //derive parameters
        $matches = array();
        preg_match('!^/?' . $this->urlFormat . '/?$!', $serviceUrl, $matches);
        array_shift($matches);
        //set params if params exist
        $params = $this->params;
        $urlParams = array();
        if (count($params) == count($matches)) {
            $urlParams = array_combine($params, $matches);
        }

        $request->addParams($urlParams);
    }

}