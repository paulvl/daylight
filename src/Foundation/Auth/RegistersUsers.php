<?php

namespace Daylight\Foundation\Auth;

use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Auth;
use Daylight\Support\Facades\Confirmation;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Daylight\Contracts\Auth\CanConfirmAccount as CanConfirmAccountContract;

trait RegistersUsers
{
    use RedirectsUsers;

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRegister()
    {
        return view('auth.register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postRegister(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $user = $this->create($request->all());

        if (! $user instanceof CanConfirmAccountContract) {
            Auth::login($user);
            return redirect($this->redirectPath());
        }

        return $this->sendConfirmationLink($request);
    }

    /**
     * Send a confirmation link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendConfirmationLink(Request $request)
    {
        $this->validate($request, ['email' => 'required|email']);

        $response = Confirmation::sendConfirmationLink($request->only('email'), function (Message $message) {
            $message->subject($this->getEmailSubject());
        });

        switch ($response) {
            case Confirmation::CONFIRMATION_LINK_SENT:
                return redirect($this->loginPath())->with('status', trans($response));

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
}
