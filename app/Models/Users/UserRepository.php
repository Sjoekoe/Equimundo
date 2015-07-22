<?php
namespace HorseStories\Models\Users;

use HorseStories\Models\Horses\Horse;

class UserRepository
{
    /**
     * @var \HorseStories\Models\Users\User
     */
    private $user;

    /**
     * @param \HorseStories\Models\Users\User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @param int $id
     * @return \HorseStories\Models\Users\User
     */
    public function findById($id)
    {
        return $this->user->where('id', $id)->firstOrFail();
    }

    /**
     * @param string $email
     * @return \HorseStories\Models\Users\User
     */
    public function findByEmail($email)
    {
        return $this->user->where('email', $email)->firstOrFail();
    }

    /**
     * @param \HorseStories\Models\Users\User $user
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findConversations(User $user)
    {
        return $this->user->find($user->id)->conversations()->orderBy('updated_at', 'DESC')->where('deleted_at', null)->get();
    }

    /**
     * @return \HorseStories\Models\Users\User[]
     */
    public function all()
    {
        return $this->user->all();
    }

    /**
     * @param string $input
     * @return \HorseStories\Models\Users\User
     */
    public function search($input)
    {
        return $this->user->where('username', 'like', '%' . $input . '%')
            ->orWhere('first_name', 'like', '%' . $input . '%')
            ->orWhere('last_name', 'like', '%' . $input . '%')
            ->get();
    }
}
