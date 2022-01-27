<?php
namespace App\Helper;

use App\Entity\ReviewAssignment;
use App\Entity\Submission;
use App\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ReviewHelper
{
    private $mail;
    public function __construct(MailHelper $mailHelper) {
        $this->mail = $mailHelper;
    }

    public function sendReviewInvitation(ReviewAssignment $reviewAssignment)
    {
        $this->mail->sendEmail($reviewAssignment->getReviewer()->getEmail(),"Invitation Review","","");
    }

 
}
