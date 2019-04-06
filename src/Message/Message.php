<?php

namespace App\Message;

class Message
{
    private $content;

    public function __construct(string $content)
    {
        $this->content = $content;
    }

}