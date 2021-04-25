<?php

/* CREATE 2 FILES FROM THIS ONE:
THE FIRST FOR DEV -> dev-params.php, 
THE SECOND FOR PROD -> prod-params.php */

// FOR ACCESS (optional modification)
define("ACCESS_KEY", "access");
define("ACCESS_DELIMITER", "!");

// FOR DATABASE (PDO)
define("DB_HOST", "localhost"); // replace "localhost"
define("DB_NAME", "database_name"); // replace "database_name"
define("DB_USER", "database_username"); // replace "database_username"
define("DB_PASS", "database_user_password"); // replace "database_user_password"
define("DB_OPTIONS", array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

// FOR MODEL (optional modification)
define("MODEL_PATH", "App\Model\\");
define("MODEL_NAME", "Model");

// FOR VIEW
define("VIEW_PATH", "../src/View"); // optional modification
define("VIEW_CACHE", false); // for prod : replace false with the cache folder path

// FOR CONTROLLER (optional modification)
define("CTRL_PATH", "App\Controller\\");
define("CTRL_DEFAULT", "Home");
define("CTRL_NAME", "Controller");
define("CTRL_METHOD_DEFAULT", "default");
define("CTRL_METHOD_NAME", "Method");

// FOR MAIL (SwiftMailer)
define("MAIL_HOST", "mail.host.com"); // replace "mail.host.com"
define("MAIL_PORT", 000); // replace "000"
define("MAIL_FROM", "mail@host.com"); // replace "mail@host.com"
define("MAIL_PASSWORD", "mail-user-password"); // replace "mail-user-password"
define("MAIL_TO", "mail@host.com"); // replace "mail@host.com"
define("MAIL_USERNAME", "mail-username"); // replace "mail-username"

// FOR RECAPTCHA (Google Recaptcha)
define("RECAPTCHA_TOKEN", "website-token"); // replace "website-token"
