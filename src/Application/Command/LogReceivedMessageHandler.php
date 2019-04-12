<?php

namespace App\Application\Command;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class LogReceivedMessageHandler implements MessageHandlerInterface
{
    public function __invoke(LogReceivedMessage $logReceivedMessageCommand)
    {
        var_dump($logReceivedMessageCommand);
    }
}
