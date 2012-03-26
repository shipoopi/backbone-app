<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Test\Mocks;

use Core\Service\WorkflowStepInterface,
    Core\Util\KeyValueStoreInterface,
    Core\Service\Request;

/**
 * Description of RequestGenerationHookMock
 *
 * @author hashin
 */
class RequestGenerationHookMock implements WorkflowStepInterface
{
    public function run(KeyValueStoreInterface $bus)
    {
        $bus->set('request', new Request());
    }
}