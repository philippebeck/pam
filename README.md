[![Pam Logo](https://pam.devsagency.net/img/pam.png)](https://github.com/devsagency/pam)

# Pam

Php Adaptive Microframework

## Overview

Pam is a PHP microframework based on the MVC architecture.

Pam is very easy to use & very light to implement.

The model part can be used for all CRUD actions & does not need to be overloaded for basic actions.

Access to the database is obviously managed by the Database part, via the PDO class.

The View part uses the Twig template engine, so it's possible to use variables, functions, filters, etc.

The Controller part inherits the essential methods of the MainController & the FrontController structures the input of the application.

The sessions are managed by Pam for user connection actions & for user alert actions, all with filters

All superglobals are managed by the GlobalsController with filters too.

The service part is managed by the ServiceController.

## Summary

-   [Package Manager](#package-manager)  
-   [Download](#download)  
-   [Content](#content)  
-   [Language](#language)  
-   [Support](#support)  
-   [Open-Source](#open-source)  
-   [Creator](#creator)  
-   [Copyright](#copyright)  

---

## Package Manager

[![Packagist Version](https://img.shields.io/packagist/v/devsagency/pam.svg?label=Packagist)](https://packagist.org/packages/devsagency/pam)

Composer : `composer require devsagency/pam`  

---

## Download

[Latest Release](https://github.com/devsagency/pam/releases)  

`git clone https://github.com/devsagency/pam.git`  
  
[![Repo Size](https://img.shields.io/github/repo-size/devsagency/pam.svg?label=Repo+Size)](https://github.com/devsagency/pam/tree/master)

---

## Content

The project contains :  
-   **config** folder => example of configuration file `params.php`  
-   **core** folder => MVC source code : `Model` - `View` - `Controller`  
-   **public** folder => example of entry point `index.php`  

[![Code Size](https://img.shields.io/github/languages/code-size/devsagency/pam.svg?label=Code+Size)](https://github.com/devsagency/pam/tree/master)

---

## Language

Pam is wrote with PHP

[![GitHub Top Language](https://img.shields.io/github/languages/top/devsagency/pam.svg?label=PHP)](https://github.com/devsagency/pam)

---

## Support

Pam has NO continuous support !

[![GitHub Last Commit](https://img.shields.io/github/last-commit/devsagency/pam.svg?label=Last+Commit)](https://github.com/devsagency/pam/commits/master)

---

## Open-Source

[![GitHub Stars](https://img.shields.io/github/stars/devsagency/pam.svg?label=GitHub+:+Pam+|+Stars)](https://github.com/devsagency/pam)

---

## Creator

Philippe Beck

[![WebSite Status](https://img.shields.io/website-up-down-green-red/https/philippebeck.net.svg?label=https://philippebeck.net)](https://philippebeck.net)
[![GitHub Followers](https://img.shields.io/github/followers/philippebeck.svg?label=GitHub+:+philippebeck+|+Followers)](https://github.com/philippebeck)


---

## Copyright

Code released under the MIT License

[![GitHub License](https://img.shields.io/github/license/devsagency/pam.svg?label=License)](https://github.com/devsagency/pam/blob/master/LICENSE)
