<?php

function giveItem($senderUser, $sentItem, $receiverUser, $amount) {
    include 'dbh.php'; // Database connection
    require_once 'package/setLog.php'; // Log function

    // Check if sender has the item
    $query = "SELECT * FROM inventory WHERE mine_author = '$senderUser' AND mine_name = '$sentItem'";
    $senderItemTable = mysqli_query($conn, $query);

    if ($senderItemTable && mysqli_num_rows($senderItemTable) > 0) {
        $senderItemRow = mysqli_fetch_assoc($senderItemTable);

        // Check if sender has enough items
        if ($senderItemRow['mine_amount'] >= $amount) {
            // Check if receiver already has the item
            $query = "SELECT * FROM inventory WHERE mine_author = '$receiverUser' AND mine_name = '$sentItem'";
            $receiverItemTable = mysqli_query($conn, $query);
            $receiverItemRow = mysqli_fetch_assoc($receiverItemTable);

            if ($receiverItemRow) {
                // Receiver has the item, update amount
                $query = "UPDATE inventory SET mine_amount = mine_amount + $amount WHERE mine_author = '$receiverUser' AND mine_name = '$sentItem'";
                mysqli_query($conn, $query);
                setLog("database queries", "{$receiverUser} already has {$sentItem}, updated amount by {$amount}");
            } else {
                // Receiver does not have the item, insert new
                $query = "INSERT INTO inventory(mine_author, mine_name, mine_amount) VALUES('$receiverUser', '$sentItem', $amount)";
                mysqli_query($conn, $query);
                setLog("database queries", "{$receiverUser} doesn't have {$sentItem}, inserted {$amount} {$sentItem} into inventory");
            }

            // Deduct from sender
            $query = "UPDATE inventory SET mine_amount = mine_amount - $amount WHERE mine_author = '$senderUser' AND mine_name = '$sentItem'";
            mysqli_query($conn, $query);
            setLog("database queries", "Removed {$amount} {$sentItem} from {$senderUser} to give to {$receiverUser}");
        } else {
            setLog("database queries", "Sender doesn't have enough {$sentItem} to give. Required: {$amount}, Available: {$senderItemRow['mine_amount']}");
        }
    } else {
        setLog("database queries", "Sender doesn't have any {$sentItem} to send");
    }
}