<?php

namespace App\Application\Command;

class LogReceivedMessage
{
    /** @var string */
    private $messageId;
    /** @var string */
    private $message;
    /** @var string */
    private $messageType;
    /** @var array */
    private $emotes;
    
    /** @var string */
    private $userId;
    /** @var string */
    private $userName;
    /** @var array|null */
    private $badges;
    /** @var string|null */
    private $badgeInfo;
    /** @var string|null */
    private $color;

    /** @var string */
    private $channel;
    /** @var string */
    private $roomId;


    public function __construct(array $payload)
    {
        $this->messageId = $payload['messageId'];
        $this->message = $payload['message'];
        $this->messageType = $payload['messageType'];
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
