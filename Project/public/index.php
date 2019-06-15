<?php

use Pam\Controller\FrontController;
use Pam\Helper\Session;
use Tracy\Debugger;

require_once '../vendor/autoload.php';

$session            = new Session();
$frontController    = new FrontController();

// Basic tests area
Debugger::enable();
// print_r($_SESSION);
// var_dump($frontController);

$frontController->run();
