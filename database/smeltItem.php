<?php

function smeltItem($author, $itemName) {
    include 'dbh.php';
    require_once 'getItem.php';

    // First, reduce the amount of coal
    $query = "UPDATE inventory SET mine_amount = mine_amount - 1 WHERE mine_author='$author' AND mine_name='Coal'";
    mysqli_query($conn, $query);

    switch (true) {
        case $itemName === 'Iron':
            // Reduce the amount of Iron
            $query = "UPDATE inventory SET mine_amount = mine_amount - 1 WHERE mine_author='$author' AND mine_name = '$itemName'";
            mysqli_query($conn, $query);

            // Check if the user has no Iron left
            if (getItem($author, 'Iron ingot') === 0) {
                // Insert a new Iron ingot
                $query = "INSERT INTO inventory(mine_author, mine_name, mine_amount) VALUES('$author', 'Iron ingot', 1)";
                mysqli_query($conn, $query);
            } else {
                // Otherwise, increase the Iron ingot count
                $query = "UPDATE inventory SET mine_amount = mine_amount + 1 WHERE mine_author='$author' AND mine_name = 'Iron ingot'";
                mysqli_query($conn, $query);
            }
            break;

        case $itemName === 'Gold':
            // Reduce the amount of Gold
            $query = "UPDATE inventory SET mine_amount = mine_amount - 1 WHERE mine_author='$author' AND mine_name = '$itemName'";
            mysqli_query($conn, $query);

            // Check if the user has no Gold left
            if (getItem($author, 'Gold ingot') === 0) {
                // Insert a new Gold ingot
                $query = "INSERT INTO inventory(mine_author, mine_name, mine_amount) VALUES('$author', 'Gold ingot', 1)";
                mysqli_query($conn, $query);
            } else {
                // Otherwise, increase the Gold ingot count
                $query = "UPDATE inventory SET mine_amount = mine_amount + 1 WHERE mine_author='$author' AND mine_name = 'Gold ingot'";
                mysqli_query($conn, $query);
            }
            break;

        case $itemName === 'Cod':
            // Reduce the amount of Gold
            $query = "UPDATE inventory SET mine_amount = mine_amount - 1 WHERE mine_author='$author' AND mine_name = '$itemName'";
            mysqli_query($conn, $query);

            // Check if the user has no Gold left
            if (getItem($author, 'Cooked cod') === 0) {
                // Insert a new Gold ingot
                $query = "INSERT INTO inventory(mine_author, mine_name, mine_amount) VALUES('$author', 'Cooked cod', 1)";
                mysqli_query($conn, $query);
            } else {
                // Otherwise, increase the Gold ingot count
                $query = "UPDATE inventory SET mine_amount = mine_amount + 1 WHERE mine_author='$author' AND mine_name = 'Cooked cod'";
                mysqli_query($conn, $query);
            }
            break;

        case $itemName === 'Salmon':
            // Reduce the amount of Gold
            $query = "UPDATE inventory SET mine_amount = mine_amount - 1 WHERE mine_author='$author' AND mine_name = '$itemName'";
            mysqli_query($conn, $query);

            // Check if the user has no Gold left
            if (getItem($author, 'Cooked salmon') === 0) {
                // Insert a new Gold ingot
                $query = "INSERT INTO inventory(mine_author, mine_name, mine_amount) VALUES('$author', 'Cooked salmon', 1)";
                mysqli_query($conn, $query);
            } else {
                // Otherwise, increase the Gold ingot count
                $query = "UPDATE inventory SET mine_amount = mine_amount + 1 WHERE mine_author='$author' AND mine_name = 'Cooked salmon'";
                mysqli_query($conn, $query);
            }
            break;
    }

    
}