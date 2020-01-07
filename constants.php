<?php

define("DB_SERVERNAME", "localhost");
define("DB_USERNAME", "jphp");
define("DB_PASSWORD", "password");
define("DB_DATABASENAME","php_task1");

define("REQUIRED"," *");

define("EXPIRY_DURATION", 1 ); //in hours

define("REGEX_PHONE", "/^\s*\d{3}\d{3}\d{4}\s*$/");
define("REGEX_NAME", "/^\s*[a-zA-Z][a-zA-Z ]*$/");
define("REGEX_CITY", "/^(?=.*[a-zA-Z])\s*[a-zA-Z0-9][a-zA-Z0-9 ]*$/");
define("REGEX_DOB","/^\s*\d\d\d\d-\d\d-\d\d\s*$/");
define("REGEX_PIN", "/^\s*[1-9][0-9]{5}\s*$/");
define("REGEX_PASSWORD", "/^(?=.*\d)(?=.*\W)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).{8,}$/");

define("PASSWORD_ERR_MSSG","Password should contain - minimum 8 character, a symbol, no spaces, a capital letter, a digit");

define("MAX_FILE_SIZE" , 1048576 ); //maximum file upload size in bytes
define('EXTENSIONS', array("jpeg","jpg","png","gif")); //allowed extensions

define("PAGINATION_LIMIT", 5 );

define("USERS_LISTING_PAGE", "usersListingPage.php" );

?>