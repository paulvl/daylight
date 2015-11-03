<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Account confirmation Settings
    |--------------------------------------------------------------------------
    |
    | Here you may set the options for confirmating accounts including the view
    | that is your account confirmation e-mail. You can also set the name of the
    | table that maintains all of the confirmation tokens for your application.
    |
    | The expire time is the number of days that the reset token should be
    | considered valid. This security feature keeps tokens mid-lived so
    | they have average time to be guessed. You may change this as needed.
    |
    */

    'email' => 'emails.confirmation',
    'table' => 'account_confirmations',
    'expire' => 7,
];