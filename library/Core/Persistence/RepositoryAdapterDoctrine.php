<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Core\Persistence;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

/**
 * Description of RepositoryAdapterDoctrine
 *
 * @author hashinpanakkaparambil
 */
class RepositoryAdapterDoctrine implements RepositoryAdapter
{

    private $em;
    private $er;
    
    public function __construct(EntityManager $em, EntityRepository $er)
    {
        $this->em = $em;
        $this->er = $er;
    }
    
    public function save($entity, $flush = true)
    {
        $this->em->persist($entity);
        if ($flush) {
            $this->em->flush();
        }
    }
   
    public function delete($entity, $flush = true)
    {
        $this->em->remove($entity);
        if ($flush) {
            $this->em->flush();
        }
    }
    
    public function __call($func, $args)
    {
        return call_user_func_array(array($this->er, $func), $args);
    }
}