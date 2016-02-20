<?php
namespace EQM\Models\Users;

use Carbon\Carbon;
use DB;

class EloquentUserRepository implements UserRepository
{
    /**
     * @var \EQM\Models\Users\EloquentUser
     */
    private $user;

    /**
     * @param \EQM\Models\Users\EloquentUser $user
     */
    public function __construct(EloquentUser $user)
    {
        $this->user = $user;
    }

    /**
     * @param array $values
     * @return \EQM\Models\Users\User
     */
    public function create(array $values)
    {
        $user = EloquentUser::create([
            'first_name' => $values['first_name'],
            'last_name' => $values['last_name'],
            'email' => $values['email'],
            'password' => bcrypt($values['password']),
            'remember_token' => $values['activationCode'],
            'language' => 'en',
            'gender' => $values['gender'],
        ]);

        $user->save();

        return $user;
    }

    /**
     * @param \EQM\Models\Users\User $user
     * @return \EQM\Models\Users\User
     */
    public function activate(User $user)
    {
        $user->actived = true;
        $user->save();

        return $user;
    }

    /**
     * @param \EQM\Models\Users\User $user
     * @param array $values
     * @return \EQM\Models\Users\User
     */
    public function update(User $user, array $values)
    {
        $user->first_name = $values['first_name'];
        $user->last_name = $values['last_name'];
        $user->country = $values['country'];
        $user->gender = $values['gender'];

        if (array_key_exists('date_of_birth', $values) && $values['date_of_birth'] !== '') {
            $user->date_of_birth = Carbon::createFromFormat('d/m/Y', $values['date_of_birth'])->startOfDay();
        }

        $user->about = array_get($values, 'about');
        $user->facebook = array_get($values, 'facebook');
        $user->twitter = array_get($values, 'twitter');
        $user->website = array_get($values, 'website');

        $user->save();

        return $user;
    }

    /**
     * @param int $id
     * @return \EQM\Models\Users\EloquentUser
     */
    public function findById($id)
    {
        return $this->user->where('id', $id)->first();
    }

    /**
     * @param string $email
     * @return \EQM\Models\Users\EloquentUser
     */
    public function findByEmail($email)
    {
        return $this->user->where('email', $email)->first();
    }

    /**
     * @param int $id
     * @param string $token
     * @return \EQM\Models\Users\User
     */
    public function findByIdAndToken($id, $token)
    {
        return $this->user->where('id', $id)->where('remember_token', $token)->first();
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
     * @return \EQM\Models\Users\EloquentUser
     */
    public function search($input)
    {
        return $this->user->where('first_name', 'like', '%' . $input . '%')
            ->orWhere('last_name', 'like', '%' . $input . '%')
            ->get();
    }

    /**
     * @return int
     */
    public function count()
    {
        return (count($this->user->all()));
    }

    /**
     * @param int $limit
     * @return \EQM\Models\Users\User[]
     */
    public function paginated($limit = 20)
    {
        return $this->user->paginate($limit);
    }

    /**
     * @param \Carbon\Carbon $start
     * @param \Carbon\Carbon $end
     * @return int
     */
    public function findCountByDate(Carbon $start, Carbon $end)
    {
        return count($this->user->where('created_at', '>', $start)->where('created_at', '<', $end)->get());
    }

    /**
     * @param \Carbon\Carbon $date
     * @return int
     */
    public function findRegisteredUsersBeforeDate(Carbon $date)
    {
        return count($this->user->where('created_at', '<=', $date)->get());
    }
}
