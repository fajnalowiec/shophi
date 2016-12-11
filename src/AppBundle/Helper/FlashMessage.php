<?php

/**
 * It is a good idea to add it later as a service and access it via container
 */

namespace AppBundle\Helper;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class FlashMessage
{

    const
        MESSAGE_STRING = 1,
        ERROR_STRING = 2;

    private $session = null;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function add($string, $stringType = self::MESSAGE_STRING)
    {
        $flashMessageType = 'message';
        if (self::MESSAGE_STRING != $stringType) {
            $flashMessageType = 'error';
        }
        $this->session->getFlashBag()->add($flashMessageType, $string);
    }

}
