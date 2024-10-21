<?php


function giveItem($senderUser, $sentItem, $reciverUser) {
    include 'dbh.php';

    // Check if sender has the item
    $query = "SELECT * FROM inventory WHERE mine_author = '$senderUser' AND mine_name = '$sentItem'";
    $senderItemTable = mysqli_query($conn, $query);
    
    if ($senderItemTable && mysqli_num_rows($senderItemTable) > 0) {
        $senderItemRow = mysqli_fetch_assoc($senderItemTable);

        // Check if sender has enough items
        if ($senderItemRow['mine_amount'] > 0) {
            // Check if receiver already has the item
            $query = "SELECT * FROM inventory WHERE mine_author = '$reciverUser' AND mine_name = '$sentItem'";
            $reciverItemTable = mysqli_query($conn, $query);
            $reciverItemRow = mysqli_fetch_assoc($reciverItemTable);

            if ($reciverItemRow) {
                // Receiver has the item, update amount
                $query = "UPDATE inventory SET mine_amount = mine_amount + 1 WHERE mine_author = '$reciverUser' AND mine_name = '$sentItem'";
            } else {
                // Receiver does not have the item, insert new
                $query = "INSERT INTO inventory(mine_author, mine_name, mine_amount) VALUES('$reciverUser', '$sentItem', 1)";
            }
            mysqli_query($conn, $query);
            
            // Deduct from sender
            $query = "UPDATE inventory SET mine_amount = mine_amount - 1 WHERE mine_author = '$senderUser' AND mine_name = '$sentItem'";
            mysqli_query($conn, $query);
        } else {
            echo "Sender does not have enough items to send.";
        }
    } else {
        echo "Sender does not have this item.";
    }
}