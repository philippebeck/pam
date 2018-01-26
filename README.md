# Pam

Php Approachable Microframework



# Installation

How to install in 4 steps:

1 / Install via Composer => $ composer require pjs/pam

2 / Move the file app/index.php in your web root folder, or the content of this file in your index.php (see index.php line 12)

3 / Then, you need to move App_Twig_Extension in your src/Helper, or create one Twig Extension with the same name & location (see FrontController.php line 72)

4 / And, you need to put this folder (app) with the config.php inside, in your project root folder (see PDOFactory.php line 29)



# Overview

Pam is a PHP microframework based on the MVC architecture.

Pam is very easy to use & very light to implement.

The model part can be used for all CRUD actions & does not need to be overloaded for basic actions.

The View part uses the Twig template engine, so it's possible to use variables, functions, filters, etc.

The Controller part inherits the essential methods of the main controller & the FrontController structures the input of the application.

The sessions are managed by Pam for user connection actions & user message actions.

Access to the database is obviously managed by the Database part, via the PDO class.



# Documentation

You will find the documentation very soon here => https://philippebeck.net/index.php?access=pjs!pam



# Contribution

Pam needs you if you like it : sends pull requests on GitHub to improve it !!
