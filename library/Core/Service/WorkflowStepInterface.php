<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Core\Service;

use Core\Util\KeyValueStoreInterface;

/**
 * Description of Hook
 *
 * @author hashin
 */
interface WorkflowStepInterface
{
    public function run(KeyValueStoreInterface $bus);
}