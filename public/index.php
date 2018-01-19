<?php

// ===================================================== \\
// ======================= P A M ======================= \\
// ========== Php Approachable Microframework ========== \\
// ===================================================== \\
// ======== https://github/philippebeck/pam.php ======== \\
// ===================================================== \\


use Pam\Controller\FrontController;


// Loads Composer autoload
require_once dirname(__DIR__).'/vendor/autoload.php';


// Creates a front controller instance
$frontController = new FrontController();


// Basic tests area
// print_r($_SESSION);
// var_dump($frontController);


// Calls the run method on the front controller instance
$frontController->run();
