<?php

namespace App\Application\Command\Message;

class PostMessageCommand
{
    /**
     * Message
     **/
    private $messageId;
    private $message;
    private $emotes;

    /**
     * User
     **/
    private $userId;
    private $userName;
    private $badges;
    private $badgeInfo;
    private $color;

    /**
     * Channel
     **/
    private $channel;
    private $roomId;


    public function __construct($payload)
    {
        $this->messageId = $payload['messageId'];
        $this->message = $payload['message'];
        $this->emotes = $payload['emotes'];
        $this->userId = $payload['userId'];
        $this->userName = $payload['userName'];
        $this->badges = $payload['badges'];
        $this->badgeInfo = $payload['badgeInfo'];
        $this->color = $payload['color'];
        $this->channel = $payload['channel'];
        $this->roomId = $payload['roomId'];
    }
}
