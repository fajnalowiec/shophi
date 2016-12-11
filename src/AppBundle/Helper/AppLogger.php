<?php

namespace AppBundle\Helper;

use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AppLogger extends BaseHelper
{

    private $logger = null;
    private $tokenStorage = null;

    public function __construct(LoggerInterface $logger, TokenStorageInterface $tokenStorage)
    {
        $this->logger = $logger;
        $this->tokenStorage = $tokenStorage;
        $this->setUserName($this->tokenStorage);
    }

    public function logMessage($string)
    {
        $this->logger->info($this->getLogString($string));
    }

    public function logException(\Exception $e)
    {
        $this->logger->error($this->getLogString($e));
    }

    private function getLogString($string)
    {
        return "[" . $this->userName . "] - " . $string;
    }

}
