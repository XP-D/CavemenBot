<?php


function validateUser($username) {
    include 'dbh.php';
    
    $query = "SELECT * FROM inventory WHERE mine_author='$username'";
    $table = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($table);

    if ($row['mine_author'] === null) {
        echo "\n USER IS NOT IN DATABASE \n";
        return true;
    } else {
        echo "\n USER IS IN DATABASE \n";
        return false;
    }
}