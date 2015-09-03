<?php

namespace Daylight\Routing;

use Daylight\Auth\SocialNetworks\SocialNetworkProviders;

class GoogleAuthController extends SocialNetworkController
{
    public function __construct()
    {
    	$this->provider = SocialNetworkProviders::GOOGLE;
    	parent::__construct();
    }
}
