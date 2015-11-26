<?php

namespace Daylight\Auth\Accounts;

use Closure;
use UnexpectedValueException;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Mail\Mailer as MailerContract;
use Daylight\Contracts\Auth\ConfirmationBroker as ConfirmationBrokerContract;
use Daylight\Contracts\Auth\CanConfirmAccount as CanConfirmAccountContract;

class ConfirmationBroker implements ConfirmationBrokerContract
{
    /**
     * The password token repository.
     *
     * @var \Daylight\Auth\Accounts\TokenRepositoryInterface
     */
    protected $tokens;

    /**
     * The user provider implementation.
     *
     * @var \Illuminate\Contracts\Auth\UserProvider
     */
    protected $users;

    /**
     * The mailer instance.
     *
     * @var \Illuminate\Contracts\Mail\Mailer
     */
    protected $mailer;

    /**
     * The view of the password reset link e-mail.
     *
     * @var string
     */
    protected $emailView;

    /**
     * The custom password validator callback.
     *
     * @var \Closure
     */
    protected $passwordValidator;

    /**
     * Create a new password broker instance.
     *
     * @param  \Daylight\Auth\Passwords\TokenRepositoryInterface  $tokens
     * @param  \Illuminate\Contracts\Auth\UserProvider  $users
     * @param  \Illuminate\Contracts\Mail\Mailer  $mailer
     * @param  string  $emailView
     * @return void
     */
    public function __construct(TokenRepositoryInterface $tokens,
                                UserProvider $users,
                                MailerContract $mailer,
                                $emailView)
    {
        $this->users = $users;
        $this->mailer = $mailer;
        $this->tokens = $tokens;
        $this->emailView = $emailView;
    }

    /**
     * Send an account confirmation link to a user.
     *
     * @param  array  $credentials
     * @param  \Closure|null  $callback
     * @return string
     */
    public function sendConfirmationLink(array $credentials, Closure $callback = null)
    {
        // First we will check to see if we found a user at the given credentials and
        // if we did not we will redirect back to this current URI with a piece of
        // "flash" data in the session to indicate to the developers the errors.
        $user = $this->getUser($credentials);

        if (is_null($user)) {
            return ConfirmationBrokerContract::INVALID_USER;
        }

        if( $user->verified )
        {
            return ConfirmationBrokerContract::ALREADY_VERIFIED;
        }

        // Once we have the reset token, we are ready to send the message out to this
        // user with a link to reset their password. We will then redirect back to
        // the current URI having nothing set in the session to indicate errors.
        $token = $this->tokens->create($user);

        $this->emailConfirmationLink($user, $token, $callback);

        return ConfirmationBrokerContract::CONFIRMATION_LINK_SENT;
    }

    /**
     * Send the account confirmation link via e-mail.
     *
     * @param  \Daylight\Contracts\Auth\CanConfirmAccount  $user
     * @param  string  $token
     * @param  \Closure|null  $callback
     * @return int
     */
    public function emailConfirmationLink(CanConfirmAccountContract $user, $token, Closure $callback = null)
    {
        // We will use the confirmation view that was given to the broker to display the
        // account confirmation e-mail. We'll pass a "token" variable into the views
        // so that it may be displayed for an user to click for account confirmation.
        $view = $this->emailView;

        return $this->mailer->send($view, compact('token', 'user'), function ($m) use ($user, $token, $callback) {
            $m->to($user->getEmailForAccountConfirmation());

            if (! is_null($callback)) {
                call_user_func($callback, $m, $user, $token);
            }
        });
    }

    /**
     * Confirm the account for the given token.
     *
     * @param  array  $credentials
     * @param  \Closure  $callback
     * @return mixed
     */
    public function confirm(array $credentials, Closure $callback)
    {
        // If the responses from the validate method is not a user instance, we will
        // assume that it is a redirect and simply return it from this method and
        // the user is properly redirected having an error message on the post.
        $user = $this->validateConfirmation($credentials);

        if (! $user instanceof CanConfirmAccountContract) {
            return $user;
        }

        // Once we have called this callback, we will remove this token row from the
        // table and return the response from this callback so the user gets sent
        // to the destination given by the developers from the callback return.
        call_user_func($callback, $user);

        $this->tokens->delete($credentials['token']);

        return ConfirmationBrokerContract::ACCOUNT_CONFIRMATION;
    }

    /**
     * Validate a password reset for the given credentials.
     *
     * @param  array  $credentials
     * @return \Illuminate\Contracts\Auth\CanConfirmAccount
     */
    protected function validateConfirmation(array $credentials)
    {
        if (! $this->tokens->exists($credentials['token'])) {
            return ConfirmationBrokerContract::INVALID_TOKEN;
        }

        $token = $this->tokens->retrieveByToken($credentials['token']);

        if (is_null($user = $this->getUser(['email' => $token->email]))) {
            return ConfirmationBrokerContract::INVALID_USER;
        }

        return $user;
    }

    /**
     * Get the user for the given credentials.
     *
     * @param  array  $credentials
     * @return \Illuminate\Contracts\Auth\CanConfirmAccount
     *
     * @throws \UnexpectedValueException
     */
    public function getUser(array $credentials)
    {
        $credentials = array_except($credentials, ['token']);

        $user = $this->users->retrieveByCredentials($credentials);

        if ($user && ! $user instanceof CanConfirmAccountContract) {
            throw new UnexpectedValueException('User must implement CanConfirmAccount interface.');
        }

        return $user;
    }

    /**
     * Get the password reset token repository implementation.
     *
     * @return \Illuminate\Auth\Passwords\TokenRepositoryInterface
     */
    protected function getRepository()
    {
        return $this->tokens;
    }
}
