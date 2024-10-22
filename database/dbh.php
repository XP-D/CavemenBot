<?php

$dbhost = 'sql8.freemysqlhosting.net';
$dbuser = 'sql8739498';
$dbpass = 'QPqC9BUd3K';
$dbname = 'sql8739498';
$conn = '';

try {
    $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    require_once 'package/setLog.php';
    setLog("database queries", "Datbase connected successfully");
} catch (mysqli_sql_exception $e) {
    echo 'Database error \n' . $e;
}