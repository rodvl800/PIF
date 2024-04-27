<?php
define('DB_HOST', '127.0.0.1:3306');
define('DB_USER', 'root');
define('DB_PASSWORD', 'mariadb');
define('DB_NAME', 'PIF');

// Establish database connection
$db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}