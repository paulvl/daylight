<?php

namespace Daylight\Database\Repositories;

use Daylight\Database\Models\SocialAccount;

class SocialAccountRepository
{
	private $provider;
	private $userModel;

	public function __construct($provider)
	{
		$this->provider = $provider;
		$this->userModel = config('auth.model');
	}

	public function instance($callbackData)
	{
		$socialAccount = SocialAccount::firstOrNew([
			'id' => $callbackData->id,
			'email' => $callbackData->email,
			'provider' => $this->provider,
			'avatar' => $callbackData->avatar
		]);

		if(!$socialAccount->exists)
		{
			$socialAccount = SocialAccount::firstOrNew([ 
				'email' => $callbackData->email
			]);
		}

		if(!$socialAccount->exists)
		{
			$socialAccount->id = $callbackData->id;
			$socialAccount->email = $callbackData->email;
			$socialAccount->provider = $this->provider;
			$socialAccount->avatar = $callbackData->avatar;
		}

		return $socialAccount;
	}

	public function createFromUser($user, SocialAccount $socialAccount)
	{
		if(!$user instanceof $this->userModel)
		{
	        throw new InvalidArgumentException("'create' method must return an instance of '".$this->userModel."'");
		}

		$socialNetworkProvider = $this->provider;

		$user->$socialNetworkProvider()->save($socialAccount);

		return $user;
	}

	public function retrieveExistingUser(SocialAccount $socialAccount, $callbackData)
	{
		$user = $socialAccount->user;

		if($this->provider != $socialAccount->provider)
		{

			$socialAccount = new SocialAccount;
			$socialAccount->id = $callbackData->id;
			$socialAccount->email = $callbackData->email;
			$socialAccount->provider = $this->provider;
			$socialAccount->avatar = $callbackData->avatar;

			$socialNetworkProvider = $this->provider;
			$user->$socialNetworkProvider()->save($socialAccount);
		}

		return $user;
	}

}