<?php

namespace App\MessageHandler;

use App\Message\PostMessage;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class PostMessageHandler implements MessageHandlerInterface
{
    public function __invoke(PostMessage $message)
    {
        var_dump($message);
    }
}
