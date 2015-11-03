<?php

namespace Daylight\Support\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Daylight\Auth\Accounts\ConfirmationBroker
 */
class Confirmation extends Facade
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
     * Constant representing an invalid token creation.
     *
     * @var string
     */
    const INVALID_TOKEN = 'confirmations.token';

    /**
     * Constant representing a null token.
     *
     * @var string
     */
    const NULL_TOKEN = 'confirmations.null_token';

    /**
     * Constant representing an already verified user.
     *
     * @var string
     */
    const ALREADY_VERIFIED = 'confirmations.already_verified';

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'auth.confirmation';
    }
}
