<?php
namespace Commands;

require_once 'api/api.php';
require_once 'api/getImage.php';
require_once 'database/setItem.php';
require_once 'database/getItem.php';
require_once 'package/setLog.php';

use Discord\Parts\Channel\Message;
use Discord\Parts\Embed\Embed;

class FishCommand
{
    private $discord;

    public function __construct($discord)
    {
        $this->discord = $discord;
    }

    public function execute(Message $message)
    {
        $authorUsername = $message->author->username;

        if (getItem($authorUsername, 'Fishing rod') === '0') {
            $embed = new Embed($this->discord);
            $embed->setTitle("Error!");
            $embed->setDescription("You need a fishing rod!");
            $embed->setFooter('Requested by '.$authorUsername);
            $embed->setTimestamp(time());
            $embed->setColor(0xff1100);
            $embed->setImage(getImage('ERR'));
            $message->channel->sendEmbed($embed);
            setLog("Fish command", "{$authorUsername} tried fishing without a fishing rod");
            return;
        } else {
            $itemData = getFish();
            $embed = new Embed($this->discord);
            $embed->setTitle($authorUsername.' caught a '.$itemData['itemName'].'!');
            $embed->setDescription($itemData['itemDesc']);
            $embed->setImage($itemData['itemImage']);
            $embed->setColor($itemData['itemColor']);
            $embed->setFooter("blublbublublub");
            $embed->setTimestamp(time());
            $message->channel->sendEmbed($embed);
            
            $itemName = $itemData['itemName'];
            setItem($authorUsername, $itemName);
            setLog("Fish command", "{$authorUsername} caught a fish and has been added to database");
            return;
        };
    }
}