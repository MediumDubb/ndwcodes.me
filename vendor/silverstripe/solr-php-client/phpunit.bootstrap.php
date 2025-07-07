<?php

require 'vendor/autoload.php';

// set error reporting high
error_reporting(E_ALL | E_STRICT);

// make sure we see them
ini_set('display_errors', 'On');

// make sure current directory and class directories are on include path
// this is necessary for auto load to work
set_include_path(
    // distribution files (where the zip / tgz is unpacked)
    dirname(dirname(__FILE__)) . PATH_SEPARATOR .

    // test file directory "tests"
    dirname(__FILE__) . PATH_SEPARATOR .

    // current include path (for PHPUnit, etc.)
    get_include_path()
);

// set up an autoload for Zend / Pear style class loading
spl_autoload_register(
    function($class)
    {
        $path = str_replace("_", DIRECTORY_SEPARATOR, $class) . ".php";
        if (file_exists($path)) {
            require $path;
        }
        if (file_exists("tests/$path")) {
            require "tests/$path";
        }
    }
);
