<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Core\Service;

/**
 *
 * @author hash
 */
interface ServiceInterface
{
    public function run(Request $request);
}