<?php
namespace EQM\Models\Users;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Hashing\Hasher;

class EloquentUserProvider implements  UserProvider
{
    /**
     * @var \Illuminate\Contracts\Hashing\Hasher
     */
    private $hasher;

    /**
     * @var \EQM\Models\Users\UserRepository
     */
    private $users;

    /**
     * @param \Illuminate\Contracts\Hashing\Hasher $hasher
     * @param \EQM\Models\Users\UserRepository $users
     */
    public function __construct(Hasher $hasher, UserRepository $users)
    {
        $this->hasher = $hasher;
        $this->users = $users;
    }

    /**
     * Retrieve a user by their unique identifier.
     *
     * @param  mixed $identifier
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveById($identifier)
    {
        return $identifier ? $this->users->findById($identifier) : null;
    }

    /**
     * Retrieve a user by their unique identifier and "remember me" token.
     *
     * @param  mixed $identifier
     * @param  string $token
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByToken($identifier, $token)
    {
        return $identifier ? $this->users->findByIdAndToken($identifier, $token) : null;
    }

    /**
     * Update the "remember me" token for the given user in storage.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable|\EQM\Models\Users\EloquentUser $user
     * @param  string $token
     * @return void
     */
    public function updateRememberToken(Authenticatable $user, $token)
    {
        $user->setRememberToken($token);

        $user->save();
    }

    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        $criteria = [];

        foreach ($credentials as $key => $value) {
            if (! str_contains($key, 'password')) {
                $criteria[$key] = $value;
            }
        }

        $email = array_get($criteria, 'email');

        return $email ? $this->users->findByEmail($email) : null;
    }

    /**
     * Validate a user against the given credentials.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable|\EQM\Models\Users\EloquentUser $user
     * @param  array $credentials
     * @return bool
     */
    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        return $this->hasher->check($credentials['password'], $user->getAuthPassword());
    }
}
