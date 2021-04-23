<?php

namespace Pam\Controller\Service;

use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

/**
 * Class MailManager
 * @package App\Controller\Service
 */
class MailManager
{
    /**
     * @param array $mail
     * @return int
     */
    public function sendMessage(array $mail)
    {
        $transport = (new Swift_SmtpTransport())
            ->setHost(MAIL_HOST)
            ->setPort(MAIL_PORT)
            ->setUsername(MAIL_FROM)
            ->setPassword(MAIL_PASSWORD)
        ;

        $mailer = new Swift_Mailer($transport);

        $message = (new Swift_Message())
            ->setSubject($mail["subject"])
            ->setFrom([MAIL_FROM => MAIL_USERNAME])
            ->setTo(
                [MAIL_TO => MAIL_USERNAME, 
                $mail["email"] => $mail["name"]]
            )
            ->setBody($mail["message"])
        ;

        return $mailer->send($message);
    }
}
