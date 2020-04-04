<?php

namespace Pam\Controller;

use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

/**
 * Class MailController
 * @package App\Controller
 */
class MailController
{
    /**
     * @param array $mail
     * @return int
     */
    public function defaultMethod(array $mail)
    {
        $transport = (new Swift_SmtpTransport(MAIL_SMTP, MAIL_PORT))
            ->setUsername(MAIL_FROM)
            ->setPassword(MAIL_PASSWORD)
        ;

        $mailer = new Swift_Mailer($transport);

        $message = (new Swift_Message())
            ->setSubject($mail['subject'])
            ->setFrom([MAIL_FROM => MAIL_USERNAME])
            ->setTo([MAIL_TO => MAIL_USERNAME, $mail['email'] => $mail['name']])
            ->setBody($mail['message'])
        ;

        $result = $mailer->send($message);

        return $result;
    }
}
