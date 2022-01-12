<?php

require 'functions.php';
// Autoload classes
spl_autoload_register(function($class) {
    require 'class/' . $class . '.php';
});

// Root directory
define("ROOT_DIRECTORY", dirname(__DIR__, 2));

// Database connection constants
const DB_HOST = 'localhost';
const DB_USER = 'root';
const DB_PASSWORD = '';
const DB_NAME = 'blog';

// Database connection
$db = new DB(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Start session
$session = new Session();

/*$test = $db->query("SELECT * FROM users")->fetchAll();

    foreach ($test as $val) {
        echo $val['username'] . "<br>";
    }*/

//$session->logout();

