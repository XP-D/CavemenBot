<?php

function setItem($author, $itemName) {
    require_once 'validateUser.php';
    include 'dbh.php';

    $query = "SELECT * FROM inventory WHERE mine_name='$itemName' AND mine_author='$author'";
    $table = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($table);

    if ($row['mine_name'] === null && $row['mine_author'] === null) {
        $query = "INSERT INTO inventory(mine_author, mine_name, mine_amount) VALUES('$author','$itemName','1')";
        mysqli_query($conn, $query);
    } else {
        $query = "UPDATE inventory SET mine_amount = mine_amount + 1 WHERE mine_author = '$author' AND mine_name = '$itemName'";
        mysqli_query($conn, $query);
    }

}