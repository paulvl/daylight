<?php

namespace Daylight\Auth\SocialNetworks;

use Daylight\Auth\SocialNetworks\SocialProviders;

trait CanLoginWithGoogle
{
    /**
     * Get the linked facbook account.
     */
    public function google()
    {
        return $this->hasOne(\Daylight\Database\Models\SocialAccount::class, 'user_id', 'id')->whereProvider(SocialProviders::GOOGLE);
    }
}
