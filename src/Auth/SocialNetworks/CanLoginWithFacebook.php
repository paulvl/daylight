<?php

namespace Daylight\Auth\SocialNetworks;

use Daylight\Auth\SocialNetworks\SocialNetworkProviders;

trait CanLoginWithFacebook
{
    /**
     * Get the linked facbook account.
     */
    public function facebook()
    {
        return $this->hasOne(\Daylight\Database\Models\SocialAccount::class, 'user_id', 'id')->whereProvider(SocialNetworkProviders::FACEBOOK);
    }
}
