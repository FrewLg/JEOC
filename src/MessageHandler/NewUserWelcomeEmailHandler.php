<?php
// src/MessageHandler/NewUserWelcomeEmailHandler.php
namespace App\MessageHandler;

use App\Message\NewUserWelcomeEmail;
use App\Repository\UserRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class NewUserWelcomeEmailHandler implements MessageHandlerInterface
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(NewUserWelcomeEmail $welcomeEmail)
    {
        $user = $this->userRepository->find($welcomeEmail->getUserId());

        // ... send an email!
    }
}

