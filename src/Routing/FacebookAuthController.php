<?php

namespace Daylight\Routing;

use Daylight\Auth\SocialNetworks\SocialProviders;

class FacebookAuthController extends SocialNetworkController
{
    public function __construct()
    {
    	$this->provider = SocialProviders::FACEBOOK;
    	parent::__construct();
    }
}
