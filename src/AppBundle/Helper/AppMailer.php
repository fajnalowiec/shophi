<?php

namespace AppBundle\Helper;

use Symfony\Bundle\TwigBundle\TwigEngine;

class AppMailer
{

    const
        INTERNAL_TITLE = '[ShopHi] ',
        INTERNAL_EMAIL_FROM = 'admin@shophi.com',
        INTERNAL_EMAIL_TO = 'fake@example.com';

    private $mailer = null;
    private $twig = null;

    public function __construct(\Swift_Mailer $mailer, TwigEngine $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function createMessage($title, $template, $templateVars = array(), $from = self::INTERNAL_EMAIL_FROM, $to = self::INTERNAL_EMAIL_TO)
    {

        return \Swift_Message::newInstance()
                ->setSubject(self::INTERNAL_TITLE . $title)
                ->setFrom($from)
                ->setTo($to)
                ->setBody(
                    $this->twig->render(
                        $template, $templateVars
                    ), 'text/plain'
        );
    }

    public function sendMessage(\Swift_Message $message)
    {
        $this->mailer->send($message);
    }

}
