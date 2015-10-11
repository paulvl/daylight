<?php

namespace Daylight\Routing;

use Auth;
use BadFunctionCallException;
use Socialite;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Daylight\Database\Repositories\SocialAccountRepository;
use Daylight\Database\Repositories\UserRepository;
use Daylight\Foundation\Auth\Paths;

abstract class SocialNetworkController extends BaseController
{
    use DispatchesJobs, ValidatesRequests, Paths;

	protected $provider;

	protected $socialAccountRepository;

    public function __construct()
    {
    	$this->socialAccountRepository = new SocialAccountRepository($this->provider);
    	$this->userRepository = new UserRepository($this->provider);
    }

    /**
     * Redirect the user to the Providers authentication page.
     *
     * @return Response
     */
    public function getIndex()
    {
        if( !method_exists($this, 'create') ) {
            throw new BadFunctionCallException("'create' method does not exists on ".get_class($this));
        }
        return Socialite::driver($this->provider)->redirect();
    }

    /**
     * Obtain the user information from Provider.
     *
     * @return Response
     */
    public function getCallback()
    {
        $callbackData = Socialite::driver($this->provider)->user();

/*        $socialAccount = \Daylight\Database\Models\SocialAccount::firstOrNew([ //fix this when Tayolor fix this part
            'id' => $callbackData->id,
            'email' => $callbackData->email,
            'provider' => $this->provider,
            'avatar' => $callbackData->avatar
        ]);

        return dd($socialAccount->exists);
*/

        $socialAccount = $this->socialAccountRepository->instance($callbackData);
        $user = $socialAccount->exists
            ? $this->socialAccountRepository->retrieveExistingUser($socialAccount, $callbackData)
            : $this->socialAccountRepository->createFromUser($this->create($callbackData), $socialAccount);
        Auth::login($user);
        return redirect($this->redirectPath())->with('status', 'Logged in with '.$this->provider);
    }
}
