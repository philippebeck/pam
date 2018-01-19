<?php

// ===================================================== \\
// ======================= P A M ======================= \\
// ========== Php Approachable Microframework ========== \\
// ===================================================== \\
// ======== https://github/philippebeck/pam.php ======== \\
// ====== https://packagist.org/packages/pjs/pam ======= \\
// ===================================================== \\



// ************************ \\
// ***** Installation ***** \\

// To install via Composer :
//$ composer require pjs/pam

// !! => After that, you need to move this file in your public folder
// !! => And you need to move App_Twig_Extension in your src/Helper



// ******************** \\
// ***** Overview ***** \\

// Pam is a microframework PHP based on MVC architecture.

// Pam is very easy to use & very light to implement.

// The Model part can be used for all CRUD actions and doesn't need to be overloaded for basic actions.

// The View part uses the template engine Twig, so it's possible to use variables, fonctions, filters, etc...

// The Controller part inherit from the main controller some very useful fonctions & the FrontController structure the application with action methods.

// Sessions are managed by Pam for log, user & message actions.

// DataBase access is managed too obviously, through the PDO class.



// ************************* \\
// ***** Documentation ***** \\

// The documentation will be added as soon as possible... please apologize for the inconvenience...



// ************************ \\
// ***** Contribution ***** \\

// Pam needs you if you like it : sends pull requests on GitHub to improve it !!



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
