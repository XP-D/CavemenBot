<?php
namespace Commands;

require_once 'api/api.php';
require_once 'database/setItem.php';
require_once 'package/setLog.php';

use Discord\Parts\Channel\Message;
use Discord\Parts\Embed\Embed;

class MineCommand
{
    private $discord;

    public function __construct($discord)
    {
        $this->discord = $discord;
    }

    public function execute(Message $message)
    {
        $itemData = apiGet(); // Assume this function is defined elsewhere
        $embed = new Embed($this->discord);
        
        $authorUsername = $message->author->username; // Get the author's username
        $embed->setTitle($authorUsername . ' found a ' . $itemData['itemName'] . '!');
        $embed->setDescription($itemData['itemDesc']);
        $embed->setImage($itemData['itemImage']);
        $embed->setColor($itemData['itemColor']);
        $embed->setFooter($itemData['itemRarity']);
        $embed->setTimestamp(time());

        $message->channel->sendEmbed($embed);
        
        $itemName = $itemData['itemName'];
        setItem($authorUsername, $itemName); // Assume this function is defined elsewhere
        setLog("Mine command", "{$authorUsername} Requested a mine item");
        return;
    }
}