<?php

use Pam\Controller\FrontController;
// Disable for Prod Mode
use Tracy\Debugger;

require_once '../vendor/autoload.php';
// Switch to prod-params.php for Prod Mode
require_once '../config/dev-params.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Disable for Prod Mode
Debugger::enable();

$frontController = new FrontController();
$frontController->run();