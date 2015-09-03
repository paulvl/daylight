<?php

namespace Daylight\Contracts\Auth;

interface CanConfirmAccount
{
    /**
     * Get the e-mail address where password reset links are sent.
     *
     * @return string
     */
    public function getEmailForAccountConfirmation();
}
