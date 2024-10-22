<?php

namespace Commands;

require_once 'api/api.php'; // Adjust as needed
require_once 'database/getItem.php'; // Adjust as needed
require_once 'database/validateUser.php'; // Adjust as needed
require_once 'package/setLog.php'; // Adjust as needed

use Discord\Parts\Channel\Message;
use Discord\Parts\Embed\Embed;

class InvCommand
{
    private $discord;

    public function __construct($discord)
    {
        $this->discord = $discord;
    }

    public function execute(Message $message)
    {
        $content = strtolower(trim($message->content));
        $authorUsername = $message->author->username; // Get the author's username

        // Check for username input
        if (preg_match('/^cinv\s+(\S+)/', $content, $matches)) {
            $username = $matches[1]; // Extract the username

            // Validate user existence
            if (validateUser($username)) {
                $this->sendErrorEmbed($message, "This username is not in our database!", $authorUsername);
                setLog("Inventory command", "{$authorUsername} Tried viewing a non existing inventory");
                return;
            } else {
                // Create the inventory embed for the specified username
                $embed = new Embed($this->discord);
                $embed->setTitle($username . "'s Inventory");
                $embed->setDescription($this->getInventoryDescription($username));
                $embed->setFooter('Requested by ' . $authorUsername);
                $embed->setTimestamp(time());
                $embed->setColor(0x212121);
                $message->channel->sendEmbed($embed);
                setLog("Inventory command", "{$authorUsername} Requested inventory successfully");
                return;
            }
        } else {
            // If no username is specified, show the author's inventory
            if (validateUser($authorUsername)) {
                $this->sendErrorEmbed($message, "You are not in our database!", $authorUsername);
                setLog("Inventory command", "{$authorUsername} Tried viewing a non existing inventory");
                return;
            } else {
                // Create the inventory embed for the author
                $embed = new Embed($this->discord);
                $embed->setTitle($authorUsername . "'s Inventory");
                $embed->setDescription($this->getInventoryDescription($authorUsername));
                $embed->setFooter('Requested by ' . $authorUsername);
                $embed->setTimestamp(time());
                $embed->setColor(0x212121);
                $message->channel->sendEmbed($embed);
                setLog("Inventory command", "{$authorUsername} Requested inventory successfully");
                return;
            }
        }
    }

    private function getInventoryDescription($username)
    {
        return "
            **<:blocks:1297308825594101771> ┆ Blocks**
            <:dirt:1296932147093049395> **`Dirt     " . getItem($username, 'Dirt') . "x`**
            <:stone:1296932168542720010> **`Stone   " . getItem($username, 'Stone') . "x`**
            <:iron:1296932191992807435> **`Iron     " . getItem($username, 'Iron') . "x`**
            <:gold:1296932202705326151> **`Gold     " . getItem($username, 'Gold') . "x`**
    
            **<:tools:1297615557972983840> ┆ Tools**
            <:furnace:1297611381931245573> **`Furnace   " . getItem($username, 'Furnace') . "x`**
            <:fishing_rod:1297614225677750392> **`Fishing rod   " . getItem($username, 'Fishing Rod') . "x`**
    
            **<:ores:1297308834712522772> ┆ Ores**
            <:coal:1296932179363889153> **`Coal     " . getItem($username, 'Coal') . "x`**
            <:iron_ingot:1297609994300293261> **`Iron Ingot     " . getItem($username, 'Iron Ingot') . "x`**
            <:gold_ingot:1297610005335379988> **`Gold Ingot     " . getItem($username, 'Gold Ingot') . "x`**
            <:diamond:1296932213941866589> **`Diamond   " . getItem($username, 'Diamond') . "x`**
    
            **<:fish:1297691173376495716> ┆ Food**
            <:cod:1297690524043575297> **`Cod     " . getItem($username, 'Cod') . "x`**
            <:salmon:1297690513717071943> **`Salmon     " . getItem($username, 'Salmon') . "x`**
            <:pufferfish:1297690503462125628> **`Pufferfish     " . getItem($username, 'Pufferfish') . "x`**
            <:cooked_cod:1297699673234083900> **`Cooked cod     " . getItem($username, 'Cooked cod') . "x`**
            <:cooked_salmon:1297699662756577371> **`Cooked salmon     " . getItem($username, 'Cooked salmon') . "x`**
            <:apple:1297717800403603557> **`Apple     " . getItem($username, 'Apple') . "x`**
            <:sweet_berries:1297717790068707329> **`Sweet berries     " . getItem($username, 'Sweet berries') . "x`**
            <:cake:1297312328093663292> **`Cake     " . getItem($username, 'Cake') . "x`**
    
            **<:obtainables:1297308843684139039> ┆ Obtainables**
            <:poppy:1296954406859964446> **`Poppy   " . getItem($username, 'Poppy') . "x`**
            <:daisy:1297313939004199004> **`Daisy   " . getItem($username, 'Daisy') . "x`**
        ";
    }

    private function sendErrorEmbed(Message $message, $errorMessage, $authorUsername)
    {
        $embed = new Embed($this->discord);
        $embed->setTitle("Error!");
        $embed->setDescription($errorMessage);
        $embed->setFooter('Requested by ' . $authorUsername);
        $embed->setTimestamp(time());
        $embed->setColor(0xff0000);
        $embed->setImage(getImage('ERR'));
        $message->channel->sendEmbed($embed);
    }
}