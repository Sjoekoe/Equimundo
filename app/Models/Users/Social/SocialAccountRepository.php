<?php
namespace EQM\Models\Users\Social;

use EQM\Models\Users\User;
use Laravel\Socialite\Contracts\User as ProviderUser;

interface SocialAccountRepository
{
    /**
     * @param \EQM\Models\Users\User $user
     * @param array $values
     * @return \EQM\Models\Users\Social\SocialAccount
     */
    public function create(User $user, array $values);
    
    /**
     * @param \Laravel\Socialite\Contracts\User $providerUser
     * @param string $provider
     * @return \EQM\Models\Users\Social\SocialAccount
     */
    public function findByProvidedUserAndProvider(ProviderUser $providerUser, $provider);
}
