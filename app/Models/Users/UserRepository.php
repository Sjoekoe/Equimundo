<?php
namespace EQM\Models\Users;

use Carbon\Carbon;
use DateTime;

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
     * @param \EQM\Models\Users\User $user
     * @param array $values
     * @return \EQM\Models\Users\User
     */
    public function update(User $user, $values)
    {
        $user->first_name = $values['first_name'];
        $user->last_name = $values['last_name'];
        $user->country = $values['country'];
        $user->gender = $values['gender'];
        $user->date_of_birth = Carbon::createFromFormat('d/m/Y', $values['date_of_birth'])->startOfDay();
        $user->about = $values['about'];
        $user->save();

        return $user;
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
