<?php

namespace Commands;

use Discord\Parts\Channel\Message;
use Discord\Parts\Embed\Embed;

class CookCommand
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
        if (preg_match('/^ccook\s+(\S+)\s+(\d+)/i', $content, $matches)) {
            $furnaceItem = ucfirst(strtolower($matches[1]));
            $amount = intval($matches[2]); // Convert to integer

            $authorItemAmount = getItem($authorUsername, $furnaceItem);
            $authorCoalAmount = getItem($authorUsername, 'Coal');

            if ($authorItemAmount < $amount) {
                $this->sendErrorEmbed($message, $authorUsername, "You don't have enough `{$furnaceItem}` to cook. Required: {$amount}, Available: {$authorItemAmount}");
                return;
            } elseif ($authorCoalAmount < $amount) {
                $this->sendErrorEmbed($message, $authorUsername, "You don't have enough `Coal` to cook {$amount} of `{$furnaceItem}`.");
                return;
            } elseif (!in_array($furnaceItem, ['Cod', 'Salmon'])) {
                $this->sendErrorEmbed($message, $authorUsername, "You can't cook `{$furnaceItem}`.");
                return;
            } else {
                // Call smeltItem with the amount
                smeltItem($authorUsername, $furnaceItem, $amount);
                $this->sendSuccessEmbed($message, $authorUsername, $furnaceItem, $amount);
            }
        } else {
            $message->channel->sendMessage("Usage: `ccook <item> <amount>`");
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
        $embed->setTitle("Cooked {$amount}x {$furnaceItem}!");
        $embed->setDescription("Took {$amount}x `Coal` for cooking.");
        $embed->setTimestamp(time());
        $embed->setFooter('Smelted by ' . $authorUsername);
        $embed->setImage(getImage("{$furnaceItem}"));
        $embed->setColor($furnaceItem === 'Cod' ? 0xc7ad95 : 0xdb8686);
        $message->channel->sendEmbed($embed);
    }
}