<?php

namespace App\Application\Command\Message;

class PostMessageCommand
{
    private $msg;
    private $username;
    private $displayName;
    private $userId;

    public function __construct($msg, $username, $displayName, $userId)
    {
        $this->msg = $msg;
        $this->username = $username;
        $this->displayName = $displayName;
        $this->userId = $userId;
    }
}
