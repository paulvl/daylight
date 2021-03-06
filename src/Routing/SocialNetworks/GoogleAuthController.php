<?php

namespace Daylight\Routing\SocialNetworks;

use Daylight\Auth\SocialNetworks\SocialProviders;

class GoogleAuthController extends SocialNetworkController
{
    public function __construct()
    {
    	$this->provider = SocialProviders::GOOGLE;
    	parent::__construct();
    }
}
