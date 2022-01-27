<?php

namespace App\Message;

use App\Entity\EmailMessage;
use App\Helper\MailHelper;
use Doctrine\ORM\EntityManagerInterface;

final class SendEmailMessage
{


    private $subject;
    private $to;
    private $template;
    private $content;
    private $emailKey;

    public function __construct($to, $emailKey, $template, $content)
    {

        $this->to = $to;
        $this->template = $template;
        $this->emailKey = $emailKey;
        $this->content = $content;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
    public function getTo(): array
    {
        return $this->to;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }
    public function setSubject($subject)
    {
         $this->subject=$subject;
    }
    public function getTemplate(): string
    {
        return $this->template;
    }
    public function getContent(): array
    {
        return $this->content;
    }
    public function sendMessage(MailHelper $mailHelper, EntityManagerInterface $em)
    {
      $emailMessage = $em->getRepository(EmailMessage::class)->findOneBy(['email_key' => $this->emailKey]);

      $body="sdfghj";
      $this->setSubject("sdfghj");
        $mailHelper->sendEmail($this->to, $this->subject, $this->template, $this->content, $body);

    }
}
