<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Core\Application;

use Doctrine\Common\Collections\Collection;
use Core\Transformation\ObjectFactoryV2;
use Core\Util\Validator;
use Core\Transformation\Request;

/**
 * Description of AssemblerAbstract
 *
 * @author hashinpanakkaparambil
 */
abstract class ServiceAbstract implements Service
{
    /**
     *
     * @var ObjectFactory
     */
    private $objectFactory;
    
    public function objectFactory()
    {
        if (!$this->objectFactory instanceof ObjectFactory) {
            $this->objectFactory = new ObjectFactoryV2();
            $this->objectFactory->enableDateTimeConversion('d/m/Y');
        }
        
        return $this->objectFactory;
    }

    public function modelCollectionToDtoCollection(
        Collection $modelcollection, $class)
    {
        Validator::nonEmptyString($class);
        Validator::classExists($class);
        $factory = $this->objectFactory();
        $dtoCollection = $modelcollection->map(
            function ($model) use ($factory, $class) {
            return $factory->objectToObject($model, $class);
        });
        return $dtoCollection;
    }
    
    public function modelToDto($model, $class)
    {
        Validator::validObject($model);
        Validator::nonEmptyString($class);
        Validator::classExists($class);
        
        $dto = $this->objectFactory()->objectToObject($model, $class);
        
        return $dto;
    }
    
    public function requestToModel(Request $request, $model)
    {
        Validator::nonEmptyString($model, 'Class name expected');
        Validator::classExists($model);
        
        return $this->objectFactory()->requestToObject($request, $model);
    }
}