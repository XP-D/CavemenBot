<?php

namespace Commands;

require_once 'database/getItem.php'; // Adjust as needed
require_once 'database/giveItem.php'; // Adjust as needed
require_once 'api/getImage.php'; // Adjust as needed

use Discord\Parts\Channel\Message;
use Discord\Parts\Embed\Embed;

class GiveCommand
{
    private $discord;

    public function __construct($discord)
    {
        $this->discord = $discord;
    }

    public function execute(Message $message)
    {
        $content = strtolower(trim($message->content));
        $authorUsername = $message->author->username;

        // Check for receiver user, item, and amount
        if (preg_match('/^cgive\s+(\S+)\s+(.+)\s+(\d+)$/', $content, $matches)) {
            $receiverUser = $matches[1];
            $receivedItem = ucfirst(strtolower($matches[2]));
            $amount = (int)$matches[3];

            // Check if author has enough items
            $authorItemAmount = getItem($authorUsername, $receivedItem);
            if ($authorItemAmount < $amount) {
                $this->sendErrorEmbed($message, $authorUsername, $receivedItem, $amount);
                return;
            }

            // Proceed to give the item
            giveItem($authorUsername, $receivedItem, $receiverUser, $amount);
            $this->sendSuccessEmbed($message, $authorUsername, $receiverUser, $receivedItem, $amount);
        } else {
            $message->channel->sendMessage("Usage: `cgive <username> <item> <amount>`");
        }
    }

    private function sendErrorEmbed(Message $message, $authorUsername, $receivedItem, $amount)
    {
        $embed = new Embed($this->discord);
        $embed->setTitle('Error!');
        $embed->setDescription("You don't have enough `{$receivedItem}` (Requested: {$amount})");
        $embed->setTimestamp(time());
        $embed->setFooter('Requested by ' . $authorUsername);
        $embed->setImage(getImage('ERR'));
        $embed->setColor(0xff0000);
        $message->channel->sendEmbed($embed);
    }

    private function sendSuccessEmbed(Message $message, $authorUsername, $receiverUser, $receivedItem, $amount)
    {
        $embed = new Embed($this->discord);
        $embed->setTitle("Success!");
        $embed->setDescription("{$authorUsername} gave {$receiverUser} {$amount}x `{$receivedItem}`!");
        $embed->setImage(getImage($receivedItem));
        $embed->setTimestamp(time());
        $embed->setColor(0x212121);
        $message->channel->sendEmbed($embed);
    }
}