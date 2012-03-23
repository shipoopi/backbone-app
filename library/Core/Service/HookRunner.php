<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Core\Service;

use Core\Service\HookInterface;

/**
 * Description of HookRunner
 *
 * @author hashin
 */
class HookRunner implements HookRunnerInterface
{
    private $hooks = array();
    private $controllerBus;
    
    public function __construct(ControllerBus $bus)
    {
        $this->controllerBus = $bus;
    }
    
    public function registerHook(HookInterface $hook)
    {
        $this->hooks[] = $hook;
        return $this;
    }

    public function runHooks()
    {
        foreach ($this->hooks as $hook) {
            $hook->run($this->controllerBus);
        }
        
        return $this->controllerBus;
    }
}