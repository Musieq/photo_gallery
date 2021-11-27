<?php

include 'database.php';

// Database connection constants
const DB_HOST = 'localhost';
const DB_USER = 'root';
const DB_PASSWORD = '';
const DB_NAME = 'blog';

// Database connection
$db = new DB(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

$db->query("SELECT * FROM users");

