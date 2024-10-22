<?php
include 'dbh.php';

function getItem($author, $itemName) {
    global $conn;
    require_once 'package/setLog.php';
    
    $query = "SELECT * FROM inventory WHERE mine_author='$author' AND mine_name='$itemName'";
    $table = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($table);

    if ($row['mine_amount'] === null) {
        setLog("database queries", "{$author} does not have any {$itemName}");
        return 0;
    } else {
        setLog("database queries", "{$author} has {$row['mine_amount']}x {$itemName}");
        return $row['mine_amount'];
    };
}