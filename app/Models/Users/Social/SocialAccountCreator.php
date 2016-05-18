<?php
namespace EQM\Models\Users\Social;

use Laravel\Socialite\Contracts\User as ProviderUser;

interface SocialAccountCreator
{
    /**
     * @param \Laravel\Socialite\Contracts\User $providerUser
     * @return \EQM\Models\Users\User
     */
    public function createOrGetUser(ProviderUser $providerUser);
}
