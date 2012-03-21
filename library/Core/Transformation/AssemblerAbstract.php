<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Core\Transformation;

use Core\Transformation\Request;
use Core\Util\Validator;

/**
 * Description of AssemblerAbstract
 *
 * @author hashinpanakkaparambil
 */
abstract class AssemblerAbstract implements Assembler
{
    /**
     *
     * @var ObjectFactory
     */
    private $objectFactory;
    
    public function objectFactory()
    {
        if (!$this->objectFactory instanceof ObjectFactory) {
            $this->objectFactory = new ObjectFactoryBasic();
        }
        
        return $this->objectFactory;
    }
    
    public function requestToModel(Request $request, $model)
    {
        Validator::nonEmptyString($model, 'Class name expected');
        Validator::classExists($model);
        
        return $this->objectFactory()->requestToObject($request, $model);
    }
}