<?php

namespace App\Application\Command;

use App\Application\Command\Message\PostMessageCommand;

class CommandFactory
{
    /**
     * @param string $commandName
     * @return string|null
     */
    public function getCommand(string $commandName)
    {
        switch ($commandName) {
            case CommandConstants::POST_MESSAGE :
                return PostMessageCommand::class;
            default:
                return null;
        }
    }
}
