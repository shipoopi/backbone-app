<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use Zend_Application_Resource_ResourceAbstract as ResourceAbstract;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Configuration;
use Core\Util\Validator;

/**
 * Description of Pimple
 *
 * @author hashinpanakkaparambil
 */
class Core_Vendor_Zend_Persistence_Resource_Doctrine extends ResourceAbstract
{

    public function init()
    {
        $pimple = $this->getBootstrap()->getResource('pimple');
        if (!$pimple instanceof \Pimple) {
            throw new RuntimeException('Pimple not bootstrapped');
        }

        $options = $this->getOptions();
        $cache = isset($options['cache']) ? $options['cache'] : null;
        $proxyDir = isset($options['proxyDir']) ? $options['proxyDir'] : null;
        $proxyNamespace = isset($options['proxyNamespace']) ?
            $options['proxyNamespace'] : null;
        $autoGenerateProxies = isset($options['autoGenerateProxies']) ?
            $options['autoGenerateProxies'] : false;

        $config = new Configuration();
        if ($cache) {
            Validator::classExists($cache);
            $cacheInstance = new $cache();
            $config->setMetadataCacheImpl($cacheInstance);
            $config->setQueryCacheImpl($cacheInstance);
        }

        $driverImpl = $config->newDefaultAnnotationDriver();
        $config->setMetadataDriverImpl($driverImpl);
        $config->setProxyDir($proxyDir);
        $config->setProxyNamespace($proxyNamespace);
        $config->setAutoGenerateProxyClasses($autoGenerateProxies);

        //set the loggers if configured
        $loggerClass = isset($options['loggerClass']) ? $options['loggerClass'] : null;

        if ($loggerClass) {

            Validator::classExists($loggerClass,
                                   sprintf(
                    'Logger class %s not found', $loggerClass));
            $logger = new $loggerClass();
            $config->setSQLLogger($logger);
        }


        $em = EntityManager::create($options, $config);
        $pimple['em'] = $em;
        Core\Application\Application::getInstance()->registerEm($em);
        return $em;
    }

}