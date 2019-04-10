<?php

namespace App\Application\Command\Message;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class PostMessageHandler implements MessageHandlerInterface
{
    public function __invoke(PostMessageCommand $message)
    {
        var_dump($message);
    }
}
