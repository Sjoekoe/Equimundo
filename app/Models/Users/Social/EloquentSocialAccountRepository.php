<?php
namespace EQM\Models\Users\Social;

use EQM\Models\Users\User;
use Laravel\Socialite\Contracts\User as ProviderUser;

class EloquentSocialAccountRepository implements SocialAccountRepository
{
    /**
     * @var \EQM\Models\Users\Social\EloquentSocialAccount
     */
    private $socialAccount;

    public function __construct(EloquentSocialAccount $socialAccount)
    {
        $this->socialAccount = $socialAccount;
    }

    /**
     * @param \EQM\Models\Users\User $user
     * @param array $values
     * @return \EQM\Models\Users\Social\SocialAccount
     */
    public function create(User $user, array $values)
    {
        $socialAccount = new EloquentSocialAccount();
        $socialAccount->user_id = $user->id();
        $socialAccount->provider = $values['provider'];
        $socialAccount->provider_user_id = $values['provider_user_id'];
        
        $socialAccount->save();
        
        return $socialAccount;
    }

    /**
     * @param \Laravel\Socialite\Contracts\User $providerUser
     * @param string $provider
     * @return \EQM\Models\Users\Social\SocialAccount
     */
    public function findByProvidedUserAndProvider(ProviderUser $providerUser, $provider)
    {
        return $this->socialAccount
            ->where('provider', $provider)
            ->where('provider_user_id', $providerUser->getId())
            ->first();
    }
}
