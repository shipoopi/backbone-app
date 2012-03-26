<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Core\Util;

/**
 *
 * @author hashin
 */
interface KeyValueStoreInterface
{
    public function set($name, $value);
    public function get($name);
}