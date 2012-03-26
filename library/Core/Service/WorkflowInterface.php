<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Core\Service;

/**
 *
 * @author hashin
 */
interface WorkflowInterface
{
    public function addStep(WorkflowStepInterface $step);
    
    public function run();
}