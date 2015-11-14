<?php
namespace EQM\Models\Users;

use EQM\Events\UserRegistered;
use EQM\Models\Roles\MemberRole;
use EQM\Models\Roles\RoleRepository;
use Illuminate\Contracts\Events\Dispatcher;

class UserCreator
{
    /**
     * @var \EQM\Models\Users\UserRepository
     */
    private $users;

    /**
     * @var \EQM\Models\Roles\RoleRepository
     */
    private $roles;

    /**
     * @var \Illuminate\Contracts\Events\Dispatcher
     */
    private $dispatcher;

    /**
     * @param \EQM\Models\Users\UserRepository $users
     * @param \EQM\Models\Roles\RoleRepository $roles
     * @param \Illuminate\Contracts\Events\Dispatcher $dispatcher
     */
    public function __construct(UserRepository $users, RoleRepository $roles, Dispatcher $dispatcher)
    {
        $this->users = $users;
        $this->roles = $roles;
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param array $data
     * @return \EQM\Models\Users\User
     */
    public function create(array $data)
    {
        $data['activationCode'] = bcrypt(str_random(30));

        $user = $this->users->create($data);
        $this->roles->create($user, new MemberRole());

        $this->dispatcher->fire(new UserRegistered($user));

        return $user;
    }
}
