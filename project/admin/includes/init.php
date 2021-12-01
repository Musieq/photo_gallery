<?php

include 'class/db.php';
include 'class/user.php';

// Database connection constants
const DB_HOST = 'localhost';
const DB_USER = 'root';
const DB_PASSWORD = '';
const DB_NAME = 'blog';

// Database connection
$db = new DB(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

/*$test = $db->query("SELECT * FROM users")->fetchAll();

    foreach ($test as $val) {
        echo $val['username'] . "<br>";
    }*/




