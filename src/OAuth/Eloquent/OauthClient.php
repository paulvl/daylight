<?php

namespace Daylight\OAuth\Eloquent;

use Illuminate\Database\Eloquent\Model;

class OauthClient extends Model
{
    protected $fillable = ['id', 'secret', 'name'];

    public static function newClient($id, $name, $secret = null)
    {    	
    	return self::create([
    		'id' => $id,
    		'secret' => is_null($secret) ? str_random(40) : $secret,
    		'name' => $name
    	]);
    }
}
