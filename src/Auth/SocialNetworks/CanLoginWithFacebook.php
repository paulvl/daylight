<?php

namespace Daylight\Auth\SocialNetworks;

use Daylight\Auth\SocialNetworks\SocialProviders;

trait CanLoginWithFacebook
{
    /**
     * Get the linked facbook account.
     */
    public function facebook()
    {
        return $this->hasOne(\Daylight\Database\Models\SocialAccount::class, 'user_id', 'id')->whereProvider(SocialProviders::FACEBOOK);
    }
}
