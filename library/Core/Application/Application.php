<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Core\Application;

use Core\Util\Validator;
use Core\Persistence\RepositoryAdapterDoctrine;

/**
 * Description of Application
 *
 * @author hashinpanakkaparambil
 */
final class Application
{
    private static $application;
    private $em;
    
    private function __construct(){}
    private function __clone(){}
    
    public static function getInstance()
    {
        if (!self::$application) {
            self::$application = new Application();
        }
        
        return self::$application;
    }
    
    public function registerEm(\Doctrine\ORM\EntityManager $em)
    {
        $this->em = $em;
        return $em;
    }
    
    public function getRepository($entity)
    {
        Validator::nonEmptyString($entity);
        Validator::classExists($entity);
        
        if (!$this->em) {
            throw new \RuntimeException('Em not registered');
        }
        
        return new RepositoryAdapterDoctrine(
            $this->em, $this->em->getRepository($entity));
    }
}