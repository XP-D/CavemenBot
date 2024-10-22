<?php

function eatItem($author, $itemName) {
    include 'dbh.php';
    require_once 'getItem.php';
    require_once 'package/setLog.php';

    // First, reduce the amount of coal
    $query = "UPDATE inventory SET mine_amount = mine_amount - 1 WHERE mine_author='$author' AND mine_name='$itemName'";
    mysqli_query($conn, $query);
    setLog("database queries", "Removed 1 {$itemName} from {$author} for eating");
}