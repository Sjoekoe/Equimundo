<?php
namespace EQM\Core\JWT;

use EQM\Models\Users\User;
use Tymon\JWTAuth\JWTAuth;

class TymonTokenGenerator implements TokenGenerator
{
    /**
     * @var \Tymon\JWTAuth\JWTAuth
     */
    private $auth;

    public function __construct(JWTAuth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @param \EQM\Models\Users\User $user
     * @return string
     */
    public function byUser(User $user)
    {
        return $this->auth->fromUser($user);
    }
}
