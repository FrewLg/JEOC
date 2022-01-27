<?php

namespace App\Helper;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class MailHelper
{


    private $mailer;
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendEmail($to, $subject, $template, $content): ?bool
    {
        $email = (new TemplatedEmail())
            ->from(new Address('rms-ju@gmail.com', 'JU-RMS'))
            ->to($to)
            ->subject($subject)
            ->htmlTemplate($template)
            ->context($content);

        try {

            $this->mailer->send($email);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
