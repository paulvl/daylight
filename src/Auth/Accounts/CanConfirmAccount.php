<?php

namespace Daylight\Auth\Accounts;

trait CanConfirmAccount
{
    /**
     * Get the e-mail address where password reset links are sent.
     *
     * @return string
     */
    public function getEmailForAccountConfirmation()
    {
        return $this->email;
    }
}
