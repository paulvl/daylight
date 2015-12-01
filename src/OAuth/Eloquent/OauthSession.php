<?php

namespace Daylight\OAuth\Eloquent;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Daylight\OAuth\Eloquent\OauthAccessToken;

class OauthSession extends Model
{
    protected $fillable = ['id', 'client_id', 'owner_type', 'owner_id', 'client_redirect_uri'];
    
	protected static function boot() {
	    parent::boot();    
	    static::deleting(function(OauthSession $session){
	    	$session->accessToken->delete();
	    });
	}

    public function accessToken()
    {
    	return $this->hasOne(OauthAccessToken::class, 'session_id', 'id');
    }
}