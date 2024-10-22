<?php

namespace Commands;

use Discord\Parts\Channel\Message;

class InviteCommand
{
    public function execute(Message $message)
    {
        if (strtolower(trim($message->content)) === 'cinvite') {
            $this->sendInviteEmbed($message);
        }
    }

    private function sendInviteEmbed(Message $message)
    {
        $inviteLink = 'https://discord.com/oauth2/authorize?client_id=1296894207750967419&scope=bot&permissions=274878254080';
        $message->embed->sendMessage($inviteLink);
    }
}