<?php
namespace EQM\Models\Users\Social;

use EQM\Models\Users\UserCreator;
use EQM\Models\Users\UserRepository;
use Illuminate\Support\Str;
use Laravel\Socialite\Contracts\User as ProviderUser;

class FaceBookAccountCreator implements SocialAccountCreator
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
        $account = $this->socialAccounts->findByProvidedUserAndProvider($providerUser, 'facebook');

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
                'first_name' => $providerUser->user['first_name'],
                'last_name' => $providerUser->user['last_name'],
                'password' => Str::random(10),
                'activationCode' => bcrypt(str_random(30)),
                'gender' => strtoupper(substr($providerUser->user['gender'], 0, 1)),
                'date_of_birth' => $providerUser->user['birthday'],
                'country' => $this->fetchCountry($providerUser->user['hometown']['name']),
                'activated' => true
            ]);
        }

        $this->socialAccounts->create($user, [
            'provider_user_id' => $providerUser->getId(),
            'provider' => 'facebook',
        ]);

        return $user;
    }

    /**
     * @param $name
     * @return int|string
     */
    private function fetchCountry($name)
    {
        $list = explode(', ', $name);

        $country = end($list);

        foreach (trans('countries') as $key => $value) {
            if ($value == $country) {
                return $key;
            }
        }

        return 'NL';
    }
}
