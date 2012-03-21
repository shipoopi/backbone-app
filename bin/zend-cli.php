<?php

defined('APPLICATION_CLIENT') || define('APPLICATION_CLIENT', 'CLI');
$bootstrapFile = dirname(__FILE__) . '/bootstrap.php';

if(!file_exists($bootstrapFile) || !is_readable($bootstrapFile)) {
    die("\033[01;31m \nImpossible to access bootstrap file, please check bootstrap/bootstrap.sample for help\n \033[0m");
}

require_once $bootstrapFile;
