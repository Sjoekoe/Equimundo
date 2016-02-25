<?php
namespace EQM\Models\Users;

use Carbon\Carbon;
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
     * @var \EQM\Models\Users\UserInterestRepository
     */
    private $interests;

    /**
     * @param \EQM\Models\Users\UserRepository $users
     * @param \EQM\Models\Roles\RoleRepository $roles
     * @param \Illuminate\Contracts\Events\Dispatcher $dispatcher
     * @param \EQM\Models\Users\UserInterestRepository $interests
     */
    public function __construct(
        UserRepository $users,
        RoleRepository $roles,
        Dispatcher $dispatcher,
        UserInterestRepository $interests
    ) {
        $this->users = $users;
        $this->roles = $roles;
        $this->dispatcher = $dispatcher;
        $this->interests = $interests;
    }

    /**
     * @param array $data
     * @return \EQM\Models\Users\User
     */
    public function create(array $data)
    {
        $data['activationCode'] = bcrypt(str_random(30));
        $data['date_of_birth'] = Carbon::createFromFormat('d/m/Y', $data['date_of_birth'])->startOfDay();

        $user = $this->users->create($data);
        $this->roles->create($user, new MemberRole());

        if (array_key_exists('interests', $data)) {
            foreach ($data['interests'] as $key => $interest) {
                $this->interests->create($user, $interest);
            }
        }

        $this->dispatcher->fire(new UserRegistered($user));

        return $user;
    }
}
