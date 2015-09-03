<?php

namespace Daylight\Database\Repositories;

class UserRepository
{
	private $model;

	public function __construct()
	{
		$this->model = config('auth.model');
	}

	public function getBySocialCredentials($user)
	{
		return call_user_func($this->model.'::whereEmail',$user->email)->first();
	}

	public function exits($user)
	{
		return !empty( call_user_func($this->model.'::whereEmail', array($user->email))->first() );
	}

}