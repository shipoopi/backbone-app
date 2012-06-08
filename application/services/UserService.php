<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

use Core\Service\ServiceInterface,
    Core\Service\Request,
    Core\Service\Representations\StringRepresentation,
    Core\Service\Representations\RepresentationFromFile;

/**
 * Description of UserService
 *
 * @author hash
 */
class UserService
{

    public function getUser(Request $request)
    {
        $vars = array('message' => 'Hello world');
        return new RepresentationFromFile(
                $vars, APPLICATION_PATH
                . '/services/representations/users.html');
    }

    public function getUsers(Request $request)
    {
        $vars = array('message' => 'Hello world');
        return new RepresentationFromFile(
                $vars, APPLICATION_PATH
                . '/services/representations/users.json');
    }

}