<?php

function validateUser($username) {
    include 'dbh.php';
    require_once 'package/setLog.php'; // Include the logging function

    $query = "SELECT * FROM inventory WHERE mine_author='$username'";
    $table = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($table);

    if ($row['mine_author'] === null) {
        setLog("user validation", "USER IS NOT IN DATABASE: $username");
        return true; // User is not in the database
    } else {
        setLog("user validation", "USER IS IN DATABASE: $username");
        return false; // User is in the database
    }
}