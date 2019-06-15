[![Pam Logo](Project/public/img/pam.png)](https://github.com/philippebeck/pam)

# Pam

Php Approachable Microframework

[![Packagist Version](https://img.shields.io/packagist/v/pjs/pam.svg?label=Packagist)](https://packagist.org/packages/pjs/pam)

## Installation

How to install in 3 steps:

1. $ composer require pjs/pam

2. Move the content of the folder vendor/pjs/pam/Project in your project root folder

3. $ composer dump-autoload

## Overview

Pam is a PHP microframework based on the MVC architecture.

Pam is very easy to use & very light to implement.

The model part can be used for all CRUD actions & does not need to be overloaded for basic actions.

The View part uses the Twig template engine, so it's possible to use variables, functions, filters, etc.

The Controller part inherits the essential methods of the main controller & the FrontController structures the input of the application.

The sessions are managed by Pam for user connection actions & user message actions.

Access to the database is obviously managed by the Database part, via the PDO class.

## Documentation

You will find the documentation here => [https://github.com/philippebeck/pam/wiki](https://github.com/philippebeck/pam/wiki)

## Contribution

Pam needs you if you like it : sends pull requests on GitHub to improve it !!
