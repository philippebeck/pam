<?php

// ********************** \\
// ***** CONFIG APP ***** \\
// ********************** \\


/** ******************************************************\
 * Defines the global constants for access to the database
 */

const CREDENTIALS = [
    "host" => "localhost",
    "user" => "root",
    "password" => "",
    "dbname" => "pam"
];

// Options for PDO instance
const OPTIONS = [
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
];
