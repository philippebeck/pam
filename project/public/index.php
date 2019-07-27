<?php

use Pam\Controller\FrontController;
use Tracy\Debugger;

include_once '../vendor/autoload.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$frontController = new FrontController();

// Basic tests area
Debugger::enable();
// print_r($_SESSION);
// var_dump($frontController);

$frontController->run();
