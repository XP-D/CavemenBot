<?php

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'cavemenbotdb';
$conn = '';

try {
    $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
} catch (mysqli_sql_exception $e) {
    echo 'Database error \n' . $e;
}