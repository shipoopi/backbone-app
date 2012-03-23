<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Test\Mocks;

use Core\Service\HookInterface,
    Core\Service\ControllerBus,
    Core\Service\Request;

/**
 * Description of RequestGenerationHookMock
 *
 * @author hashin
 */
class RequestGenerationHookMock implements HookInterface
{
    public function run(ControllerBus $bus)
    {
        $bus->set('request', new Request());
    }
}