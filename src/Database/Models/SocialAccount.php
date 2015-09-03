<?php

namespace Daylight\Database\Models;

use Illuminate\Database\Eloquent\Model;

class SocialAccount extends Model
{
    // protected $table = 'users';
    // 
	private $userModel;

    protected $fillable = ['id', 'email', 'provider', 'avatar', 'user_id'];

	public function __construct()
	{
		$this->userModel = config('auth.model');
	}

	/**
	 * Get the user that owns the phone.
	 */
	public function user()
	{
	    return $this->belongsTo($this->userModel, 'user_id', 'id');
	}
	
}