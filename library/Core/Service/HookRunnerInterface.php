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
interface HookRunnerInterface
{
    public function registerHook(HookInterface $hook);
    
    public function runHooks();
}