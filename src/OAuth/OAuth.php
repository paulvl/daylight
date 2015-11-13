<?php

namespace Daylight\OAuth;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;
use Daylight\OAuth\Eloquent\OauthAccessToken;

class OAuth {

	public static function getAccessTokenEntity()
	{
		return Authorizer::getChecker()->getAccessToken();
	}

	public static function getAccessToken()
	{
		return Authorizer::getChecker()->getAccessToken()->getId();
	}

	public static function expireRequestToken()
	{
		self::getAccessTokenEntity()->expire();
	}

	public static function getRequestSession()
	{
		$accessTokenEntity = self::getAccessTokenEntity();
    	return is_null($accessTokenEntity) ? $accessTokenEntity : $accessTokenEntity->getSession();
	}

	public static function expireRequestSession()
	{
		//Submit changes to lucadegasperi and change this
    	OauthAccessToken::find(self::getAccessToken())->session->delete();
	}

}