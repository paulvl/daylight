<?php

namespace Daylight\Foundation\Auth;

use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Auth;
use Daylight\Support\Facades\Confirmation;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

trait ApiConfirmsAccounts
{
    /**
     * Send a confirmation link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postEmail(Request $request)
    {
        $this->validate($request, ['email' => 'required|email']);

        $response = Confirmation::sendConfirmationLink($request->only('email'), function (Message $message) {
            $message->subject($this->getEmailSubject());
        });

        switch ($response) {
            case Confirmation::CONFIRMATION_LINK_SENT:
                return responseJsonOk(['message' => trans($response)]);

            case Confirmation::INVALID_TOKEN:
                return responseJsonUnprocessableEntity(['message' => 'invalid token', 'errors' => ['email' => trans($response)]]);
        }
    }

    /**
     * Get the e-mail subject line to be used for the reset link email.
     *
     * @return string
     */
    protected function getEmailSubject()
    {
        return isset($this->subject) ? $this->subject : 'Your Account Confirmation Link';
    }

    /**
     * Display the password reset view for the given token.
     *
     * @param  string  $token
     * @return \Illuminate\Http\Response
     */
    public function getConfirm($token = null)
    {
        if (is_null($token)) {
            return responseJsonNotFound(['message' => '', 'errors' => '']);
        }

        $credentials = ['token' => $token];

        $response = Confirmation::confirm($credentials, function ($user) {
            $this->confirmAccount($user);
        });

        switch ($response) {
            case Confirmation::ACCOUNT_CONFIRMATION:
                return responseJsonOk(['message' => trans($response), 'data' => null]);

            default:
                return responseJsonUnprocessableEntity(['message' => '', 'errors' => ['email' => trans($response)]]);
        }
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Daylight\Contracts\Auth\CanConfirmAccunt  $user
     * @return void
     */
    protected function confirmAccount($user)
    {
        $user->verified = true;
        $user->save();
    }
}
