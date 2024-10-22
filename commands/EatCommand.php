<?php

namespace Commands;

use Discord\Parts\Channel\Message;
use Discord\Parts\Embed\Embed;

class EatCommand
{
    private $discord;

    public function __construct($discord)
    {
        $this->discord = $discord;
    }

    public function execute(Message $message, $authorUsername)
    {
        if (preg_match('/^ceat\s+(.+)/i', strtolower($message->content), $matches)) {
            $eatenItem = ucfirst(strtolower($matches[1]));

            $authorItemAmount = getItem($authorUsername, $eatenItem);
            if ($authorItemAmount === '0') {
                $this->sendErrorEmbed($message, $authorUsername, "You don't have enough `{$eatenItem}` to eat.");
                return;
            }

            if (!$this->isEdibleItem($eatenItem)) {
                $this->sendErrorEmbed($message, $authorUsername, "You can't eat or have too little `{$eatenItem}`!");
                return;
            }

            $this->processEating($message, $authorUsername, $eatenItem);
        }
    }

    private function isEdibleItem($item)
    {
        return in_array($item, ['Cooked cod', 'Cooked salmon', 'Cake', 'Apple', 'Sweet berries', 'Cod', 'Salmon', 'Pufferfish']);
    }

    private function processEating(Message $message, $authorUsername, $eatenItem)
    {
        eatItem($authorUsername, $eatenItem);

        $embed = new Embed($this->discord);
        $embed->setTitle("{$authorUsername} ate " . strtolower($eatenItem) . '!');

        switch ($eatenItem) {
            case 'Cod':
                $embed->setDescription("Eww, that was flipping raw!!!");
                $embed->setImage(getImage('Cod'));
                $embed->setColor(0xc7ad95);
                break;
            case 'Cooked cod':
                $embed->setDescription("Ahh yess, that was very good.");
                $embed->setImage(getImage('Cooked cod'));
                $embed->setColor(0xdb8686);
                break;
            case 'Salmon':
                $embed->setDescription("Eww, that was flipping raw!!!");
                $embed->setImage(getImage('Salmon'));
                $embed->setColor(0xdb8686);
                break;
            case 'Cooked salmon':
                $embed->setDescription("Ahh yess, that was very good.");
                $embed->setImage(getImage('Cooked salmon'));
                $embed->setColor(0xdb8686);
                break;
            case 'Pufferfish':
                $this->handlePufferfish($embed, $authorUsername);
                break;
            case 'Cake':
            case 'Apple':
            case 'Sweet berries':
                $embed->setDescription("Ahh yess, that was very good.");
                $embed->setImage(getImage($eatenItem));
                $embed->setColor(0xdb8686);
                break;
        }

        $embed->setTimestamp(time());
        $embed->setFooter('Eaten by ' . $authorUsername);
        $message->channel->sendEmbed($embed);
    }

    private function handlePufferfish(Embed $embed, $authorUsername)
    {
        $rand = rand(0, 1);
        $embed->setTitle("{$authorUsername} ate a pufferfish!");

        if ($rand === 1) {
            $embed->setDescription("AHHHH I GOT POISONED!!!");
            $embed->setImage(getImage('Pufferfish'));
            $embed->setColor(0x477000);
        } else {
            $embed->setDescription("Eww, that was flipping raw!!!");
            $embed->setImage(getImage('Pufferfish'));
            $embed->setColor(0xffdb3b);
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
}