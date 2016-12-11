<?php

namespace AppBundle\Helper;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class BaseHelper
{

    const
        NO_USER = 'NO_USER',
        ANON_USER = 'anon.',
        ERROR_USER = 'CANNOT_GET_USERNAME';

    protected $userName = self::NO_USER;

    protected function setUserName(TokenStorageInterface $tokenStorage)
    {
        try {
            if (self::ANON_USER === $this->userName = $tokenStorage->getToken()->getUser()) {
                $this->userName = self::ANON_USER;
            } else {
                $this->userName = $tokenStorage->getToken()->getUser()->getUsername();
            }
        } catch (\Exception $e) {
            $this->userName = self::ERROR_USER;
        }
    }

}
