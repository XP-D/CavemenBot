<?php

namespace Commands;

use Discord\Parts\Channel\Message;
use Discord\Parts\Embed\Embed;

class MeltCommand
{
    private $discord;

    public function __construct($discord)
    {
        $this->discord = $discord;
    }

    public function execute(Message $message, $authorUsername)
    {
        $content = strtolower(trim($message->content));

        // Update regex to capture amount
        if (preg_match('/^cmelt\s+(\S+)\s+(\d+)/i', $content, $matches)) {
            $furnaceItem = ucfirst(strtolower($matches[1]));
            $amount = intval($matches[2]); // Convert to integer

            $authorItemAmount = getItem($authorUsername, $furnaceItem);
            $authorCoalAmount = getItem($authorUsername, 'Coal');

            if ($authorItemAmount < $amount) {
                $this->sendErrorEmbed($message, $authorUsername, "You don't have enough `{$furnaceItem}` to smelt. Required: {$amount}, Available: {$authorItemAmount}");
                return;
            } elseif ($authorCoalAmount < $amount) {
                $this->sendErrorEmbed($message, $authorUsername, "You don't have enough `Coal` to smelt {$amount} of `{$furnaceItem}`.");
                return;
            } elseif (!in_array($furnaceItem, ['Iron', 'Gold'])) {
                $this->sendErrorEmbed($message, $authorUsername, "You can't smelt `{$furnaceItem}`.");
                return;
            } else {
                // Call smeltItem with the amount
                smeltItem($authorUsername, $furnaceItem, $amount);
                $this->sendSuccessEmbed($message, $authorUsername, $furnaceItem, $amount);
            }
        } else {
            $message->channel->sendMessage("Usage: `cmelt <item> <amount>`");
        }
    }

    private function sendErrorEmbed(Message $message, $authorUsername, $errorMessage)
    {
        $embed = new Embed($this->discord);
        $embed->setTitle('Error!');
        $embed->setDescription($errorMessage);
        $embed->setTimestamp(time());
        $embed->setFooter('Requested by ' . $authorUsername);
        $embed->setImage(getImage('ERR'));
        $embed->setColor(0xff0000);
        $message->channel->sendEmbed($embed);
    }

    private function sendSuccessEmbed(Message $message, $authorUsername, $furnaceItem, $amount)
    {
        $embed = new Embed($this->discord);
        $embed->setTitle("Smelted {$amount}x {$furnaceItem}!");
        $embed->setDescription("Took {$amount}x `Coal` for smelting.");
        $embed->setTimestamp(time());
        $embed->setFooter('Smelted by ' . $authorUsername);
        $embed->setImage(getImage("{$furnaceItem} ingot"));
        $embed->setColor($furnaceItem === 'Iron' ? 0xd6d6d6 : 0xffd000);
        $message->channel->sendEmbed($embed);
    }
}