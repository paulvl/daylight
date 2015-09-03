<?php

namespace Daylight\Auth\SocialNetworks;

use Daylight\Auth\SocialNetworks\SocialNetworkProviders;

trait CanLoginWithGoogle
{
    /**
     * Get the linked facbook account.
     */
    public function google()
    {
        return $this->hasOne(\Daylight\Database\Models\SocialAccount::class, 'user_id', 'id')->whereProvider(SocialNetworkProviders::GOOGLE);
    }
}
