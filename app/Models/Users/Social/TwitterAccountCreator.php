<?php
namespace EQM\Models\Users\Social;

use Carbon\Carbon;
use EQM\Models\Users\UserCreator;
use EQM\Models\Users\UserRepository;
use Illuminate\Support\Str;
use Laravel\Socialite\Contracts\User as ProviderUser;

class TwitterAccountCreator implements SocialAccountCreator
{
    /**
     * @var \EQM\Models\Users\Social\SocialAccountRepository
     */
    private $socialAccounts;

    /**
     * @var \EQM\Models\Users\UserRepository
     */
    private $users;

    /**
     * @var \EQM\Models\Users\UserCreator
     */
    private $creator;

    public function __construct(SocialAccountRepository $socialAccounts, UserRepository $users, UserCreator $creator)
    {
        $this->socialAccounts = $socialAccounts;
        $this->users = $users;
        $this->creator = $creator;
    }

    /**
     * @param \Laravel\Socialite\Contracts\User $providerUser
     * @return \EQM\Models\Users\User
     */
    public function createOrGetUser(ProviderUser $providerUser)
    {
        $account = $this->socialAccounts->findByProvidedUserAndProvider($providerUser, 'twitter');

        if ($account) {
            return $account->user();
        }

        $user = null;

        if (array_key_exists('email', $providerUser->user)) {
            $user = $this->users->findByEmail($providerUser->user['email']);
        }

        if (! $user) {
            $user = $this->creator->create([
                'email' => array_get($providerUser->user, 'email'),
                'first_name' => $providerUser->getName(),
                'last_name' => '',
                'password' => Str::random(10),
                'activationCode' => bcrypt(str_random(30)),
                'gender' => 'F',
                'date_of_birth' => Carbon::now()->subYears(13)->format('d/m/Y'),
                'country' => 'BE',
                'activated' => true,
                'twitter' => $providerUser->getNickname(),
            ]);
        }

        $this->socialAccounts->create($user, [
            'provider_user_id' => $providerUser->getId(),
            'provider' => 'twitter',
        ]);

        return $user;
    }
}
