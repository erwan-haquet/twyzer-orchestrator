<?php

namespace App\UI\RabbitMQ\ActionHandler;

use App\UI\RabbitMQ\Action\MessagePosted;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class MessagePostedHandler implements MessageHandlerInterface
{
    public function __invoke(MessagePosted $message)
    {
        var_dump($message);
    }
}
