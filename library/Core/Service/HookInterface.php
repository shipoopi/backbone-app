<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Core\Service;

use Core\Service\ControllerBus;

/**
 * Description of Hook
 *
 * @author hashin
 */
interface HookInterface
{
    public function run(ControllerBus $bus);
}