<?php

namespace App\Factory;

use App\Constant\ActionConstants;
use App\Message\PostMessage;

class MessageFactory
{
    /**
     * @param string $action
     * @return string|null
     */
    public function getMessageClass(string $action)
    {
        switch($action){
            case ActionConstants::POST_MESSAGE :
                return PostMessage::class ;
            default:
                return null;
        }
    }
}
