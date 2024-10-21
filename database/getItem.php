<?php
include 'dbh.php';

function getItem($author, $itemName) {
    global $conn;
    
    $query = "SELECT * FROM inventory WHERE mine_author='$author' AND mine_name='$itemName'";
    $table = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($table);

    if ($row['mine_amount'] === null) {
        return 0;
    } else {
        return $row['mine_amount'];
    };
}