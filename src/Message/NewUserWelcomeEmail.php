<?php 
// src/Message/NewUserWelcomeEmail.php
namespace App\Message;

class NewUserWelcomeEmail
{
    private $userId;

    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}

