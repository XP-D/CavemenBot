<?php

function smeltItem($author, $itemName, $amount) {
    include 'dbh.php';
    require_once 'getItem.php';
    require_once 'package/setLog.php'; // Include the logging function

    // First, reduce the amount of coal
    $query = "UPDATE inventory SET mine_amount = mine_amount - $amount WHERE mine_author='$author' AND mine_name='Coal'";
    mysqli_query($conn, $query);
    setLog("database queries", "Reduced $amount Coal for smelting by $author");

    switch ($itemName) {
        case 'Iron':
            // Reduce the amount of Iron
            $query = "UPDATE inventory SET mine_amount = mine_amount - $amount WHERE mine_author='$author' AND mine_name='$itemName'";
            mysqli_query($conn, $query);
            setLog("database queries", "Reduced $amount Iron for smelting by $author");

            // Check if the user has no Iron ingots left
            if (getItem($author, 'Iron ingot') === 0) {
                // Insert new Iron ingots
                $query = "INSERT INTO inventory(mine_author, mine_name, mine_amount) VALUES('$author', 'Iron ingot', $amount)";
                mysqli_query($conn, $query);
                setLog("database queries", "Inserted $amount Iron ingot for $author");
            } else {
                // Otherwise, increase the Iron ingot count
                $query = "UPDATE inventory SET mine_amount = mine_amount + $amount WHERE mine_author='$author' AND mine_name='Iron ingot'";
                mysqli_query($conn, $query);
                setLog("database queries", "Increased Iron ingot count by $amount for $author");
            }
            break;

        case 'Gold':
            // Reduce the amount of Gold
            $query = "UPDATE inventory SET mine_amount = mine_amount - $amount WHERE mine_author='$author' AND mine_name='$itemName'";
            mysqli_query($conn, $query);
            setLog("database queries", "Reduced $amount Gold for smelting by $author");

            // Check if the user has no Gold ingots left
            if (getItem($author, 'Gold ingot') === 0) {
                // Insert new Gold ingots
                $query = "INSERT INTO inventory(mine_author, mine_name, mine_amount) VALUES('$author', 'Gold ingot', $amount)";
                mysqli_query($conn, $query);
                setLog("database queries", "Inserted $amount Gold ingot for $author");
            } else {
                // Otherwise, increase the Gold ingot count
                $query = "UPDATE inventory SET mine_amount = mine_amount + $amount WHERE mine_author='$author' AND mine_name='Gold ingot'";
                mysqli_query($conn, $query);
                setLog("database queries", "Increased Gold ingot count by $amount for $author");
            }
            break;

        case 'Cod':
            // Reduce the amount of Cod
            $query = "UPDATE inventory SET mine_amount = mine_amount - $amount WHERE mine_author='$author' AND mine_name='$itemName'";
            mysqli_query($conn, $query);
            setLog("database queries", "Reduced $amount Cod for cooking by $author");

            // Check if the user has no Cooked Cod left
            if (getItem($author, 'Cooked cod') === 0) {
                // Insert new Cooked Cod
                $query = "INSERT INTO inventory(mine_author, mine_name, mine_amount) VALUES('$author', 'Cooked cod', $amount)";
                mysqli_query($conn, $query);
                setLog("database queries", "Inserted $amount Cooked cod for $author");
            } else {
                // Otherwise, increase the Cooked Cod count
                $query = "UPDATE inventory SET mine_amount = mine_amount + $amount WHERE mine_author='$author' AND mine_name='Cooked cod'";
                mysqli_query($conn, $query);
                setLog("database queries", "Increased Cooked cod count by $amount for $author");
            }
            break;

        case 'Salmon':
            // Reduce the amount of Salmon
            $query = "UPDATE inventory SET mine_amount = mine_amount - $amount WHERE mine_author='$author' AND mine_name='$itemName'";
            mysqli_query($conn, $query);
            setLog("database queries", "Reduced $amount Salmon for cooking by $author");

            // Check if the user has no Cooked Salmon left
            if (getItem($author, 'Cooked salmon') === 0) {
                // Insert new Cooked Salmon
                $query = "INSERT INTO inventory(mine_author, mine_name, mine_amount) VALUES('$author', 'Cooked salmon', $amount)";
                mysqli_query($conn, $query);
                setLog("database queries", "Inserted $amount Cooked salmon for $author");
            } else {
                // Otherwise, increase the Cooked Salmon count
                $query = "UPDATE inventory SET mine_amount = mine_amount + $amount WHERE mine_author='$author' AND mine_name='Cooked salmon'";
                mysqli_query($conn, $query);
                setLog("database queries", "Increased Cooked salmon count by $amount for $author");
            }
            break;
    }
}