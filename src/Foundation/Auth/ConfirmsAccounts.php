<?php

namespace Daylight\Foundation\Auth;

use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Auth;
use Daylight\Support\Facades\Confirmation;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

trait ConfirmsAccounts
{
    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function getEmail()
    {
        return view('auth.confirmation');
    }

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
                return redirect($this->loginPath())->with('status', trans($response));
                
            case Confirmation::ALREADY_VERIFIED:
                return responseJsonOk(['message' => trans($response)]);

            case Confirmation::INVALID_TOKEN:
                return redirect()->back()->withErrors(['email' => trans($response)]);
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
            throw new NotFoundHttpException;
        }

        $credentials = ['token' => $token];

        $response = Confirmation::confirm($credentials, function ($user) {
            $this->confirmAccount($user);
        });

        switch ($response) {
            case Confirmation::ACCOUNT_CONFIRMATION:
                return redirect($this->redirectPath())->with('status', trans($response));

            default:
                return redirect()->back()
                            ->withErrors(['email' => trans($response)]);
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

        Auth::login($user);
    }

    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectPath()
    {
        if (property_exists($this, 'redirectPath')) {
            return $this->redirectPath;
        }

        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/home';
    }

    /**
     * Get the path to the login route.
     *
     * @return string
     */
    public function loginPath()
    {
        return property_exists($this, 'loginPath') ? $this->loginPath : '/auth/login';
    }
}
