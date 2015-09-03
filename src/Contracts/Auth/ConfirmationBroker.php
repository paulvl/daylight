<?php

namespace Daylight\Contracts\Auth;

use Closure;

interface ConfirmationBroker
{
    /**
     * Constant representing a successfully sent confirmation.
     *
     * @var string
     */
    const CONFIRMATION_LINK_SENT = 'confirmations.sent';

    /**
     * Constant representing a successfully account confirmation.
     *
     * @var string
     */
    const ACCOUNT_CONFIRMATION = 'confirmations.verified';

    /**
     * Constant representing the user not found response.
     *
     * @var string
     */
    const INVALID_USER = 'confirmations.user';

    /**
     * Constant representing an invalid token.
     *
     * @var string
     */
    const INVALID_TOKEN = 'confirmations.token';

    /**
     * Send an account confirmation link to a user.
     *
     * @param  array  $credentials
     * @param  \Closure|null  $callback
     * @return string
     */
    public function sendConfirmationLink(array $credentials, Closure $callback = null);

    /**
     * Confirm the account for the given token.
     *
     * @param  array     $credentials
     * @param  \Closure  $callback
     * @return mixed
     */
    public function confirm(array $credentials, Closure $callback);
}
