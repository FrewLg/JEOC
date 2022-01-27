<?php

namespace App\MessageHandler;

use App\Helper\MailHelper;
use App\Message\SendEmailMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class SendEmailMessageHandler implements MessageHandlerInterface
{
    private $mailHelper;
    private $em;

    public function __construct(MailHelper $mailHelper, EntityManagerInterface $em)
    {

        $this->mailHelper = $mailHelper;
        $this->em = $em;
    }

    public function __invoke(SendEmailMessage $message)
    {


        $message->sendMessage($this->mailHelper, $this->em);
    }
}
