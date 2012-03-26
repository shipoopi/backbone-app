<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Core\Service;

use Core\Service\WorkflowInterface,
    Core\Util\KeyValueStoreInterface;

/**
 * Description of HookRunner
 *
 * @author hashin
 */
class Workflow implements WorkflowInterface
{
    private $steps = array();
    private $bus;
    
    public function __construct(KeyValueStoreInterface $bus)
    {
        $this->bus = $bus;
    }
    
    public function addStep(WorkflowStepInterface $step)
    {
        $this->steps[] = $step;
        return $this;
    }

    public function run()
    {
        foreach ($this->steps as $step) {
            $step->run($this->bus);
        }
        
        return $this->bus;
    }
}