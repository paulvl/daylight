<?php

namespace Daylight\Routing;

use Daylight\Auth\SocialNetworks\SocialNetworkProviders;

class FacebookAuthController extends SocialNetworkController
{
    public function __construct()
    {
    	$this->provider = SocialNetworkProviders::FACEBOOK;
    	parent::__construct();
    }
}
