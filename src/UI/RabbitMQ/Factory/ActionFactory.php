<?php

namespace App\UI\RabbitMQ\Factory;

use App\UI\RabbitMQ\Constant\ActionConstants;
use App\UI\RabbitMQ\Action\MessagePosted;

class ActionFactory
{
    /**
     * @param string $actionName
     * @return string|null
     */
    public function getAction(string $actionName)
    {
        switch ($actionName) {
            case ActionConstants::MESSAGE_POSTED :
                return MessagePosted::class;
            default:
                return null;
        }
    }
}
