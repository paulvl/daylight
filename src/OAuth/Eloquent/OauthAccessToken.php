<?php

namespace Daylight\OAuth\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Daylight\OAuth\Eloquent\OauthSession;

class OauthAccessToken extends Model
{
    public static function removeExpiredOnes()
    {
    	$accessTokens = self::where('expire_time', '<', time())->get();

    	foreach ($accessTokens as $accessToken) {
    		$accessToken->session->delete();
    	}
    }

    public function session()
    {
    	return $this->belongsTo(OauthSession::class, 'session_id', 'id');
    }
}
