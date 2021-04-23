<?php

namespace Pam\Controller\Service;

use Pam\Controller\GlobalsController;
use ReCaptcha\ReCaptcha;

/**
 * Class SecurityManager
 * @package Pam\Controller\Service
 */
class SecurityManager extends GlobalsController
{
    /**
     * @param string $response
     * @return bool
     */
    public function checkRecaptcha(string $response)
    {
        $recaptcha = new ReCaptcha(RECAPTCHA_TOKEN);

        $result = $recaptcha
            ->setExpectedHostname(
                $this->getServer()->getServerVar("SERVER_NAME")
            )
            ->verify(
                $response, 
                $this->getServer()->getServerVar("REMOTE_ADDR")
            );

        return $result->isSuccess();
    }

    /**
     * @return bool
     */
    public function checkIsAdmin()
    {
        $session = $this->getSession()->getSessionArray();
        $isAdmin = false;

        if (isset($session["user"]["admin"])) {
            if (
                $this->getSession()->getUserVar("admin") === true 
                || $this->getSession()->getUserVar("admin") === 1
            ) {
                $isAdmin = true;
            }

        } elseif (isset($session["user"]["role"])) {
            if (
                $this->getSession()->getUserVar("role") === 1
                || $this->getSession()->getUserVar("role") === "admin"
            ) {
                $isAdmin = true;
            }

        } else {
            if ($this->getSession()->islogged() === true) {
                $isAdmin = true;
            }
        }

        if ($isAdmin === false) {
            $this->getSession()->createAlert(
                "You must be logged in as Admin to access to the administration", 
                "black"
            );
        }

        return $isAdmin;
    }
}
