<?php
namespace EQM\Models\Users;

class UserRepository
{
    /**
     * @var \EQM\Models\Users\User
     */
    private $user;

    /**
     * @param \EQM\Models\Users\User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @param int $id
     * @return \EQM\Models\Users\User
     */
    public function findById($id)
    {
        return $this->user->where('id', $id)->firstOrFail();
    }

    /**
     * @param string $email
     * @return \EQM\Models\Users\User
     */
    public function findByEmail($email)
    {
        return $this->user->where('email', $email)->firstOrFail();
    }

    /**
     * @param \EQM\Models\Users\User $user
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findConversations(User $user)
    {
        return $this->user->find($user->id)->conversations()->orderBy('updated_at', 'DESC')->where('deleted_at', null)->get();
    }

    /**
     * @return \EQM\Models\Users\User[]
     */
    public function all()
    {
        return $this->user->all();
    }

    /**
     * @param string $input
     * @return \EQM\Models\Users\User
     */
    public function search($input)
    {
        return $this->user->where('first_name', 'like', '%' . $input . '%')
            ->orWhere('last_name', 'like', '%' . $input . '%')
            ->get();
    }
}
