<?php
namespace EQM\Models\Users;

use Carbon\Carbon;
use DB;
use EQM\Core\Slugs\SlugCreator;
use Location;

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
            'activation_key' => $values['activationCode'],
            'language' => 'en',
            'timezone' => 'UTC',
            'gender' => $values['gender'],
            'slug' => (new SlugCreator())->createForUser($values['first_name'], $values['last_name']),
            'date_of_birth' => $values['date_of_birth'],
            'country' => $values['country'],
            'sidebar_collapsed' => true,
        ]);
        
        if (array_key_exists('activated', $values)) {
            $user->activated = true;
        }

        $user->save();

        return $user;
    }

    /**
     * @param \EQM\Models\Users\User $user
     * @return \EQM\Models\Users\User
     */
    public function activate(User $user)
    {
        $user->activated = true;
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
        if (array_key_exists('first_name', $values)) {
            $user->first_name = $values['first_name'];
        }

        if (array_key_exists('last_name', $values)) {
            $user->last_name = $values['last_name'];
        }

        if (array_key_exists('country', $values)) {
            $user->country = $values['country'];
        }

        if (array_key_exists('gender', $values)) {
            $user->gender = $values['gender'];
        }

        if (array_key_exists('date_of_birth', $values) && $values['date_of_birth'] !== '') {
            $user->date_of_birth = Carbon::createFromFormat('d/m/Y', $values['date_of_birth'])->startOfDay();
        }

        if (array_key_exists('about', $values)) {
            $user->about = array_get($values, 'about');
        }

        if (array_key_exists('facebook', $values)) {
            $user->facebook = array_get($values, 'facebook');
        }

        if (array_key_exists('twitter', $values)) {
            $user->twitter = array_get($values, 'twitter');
        }

        if (array_key_exists('website', $values)) {
            $user->website = array_get($values, 'website');
        }

        if (array_key_exists('sidebar_collapsed', $values)) {
            $value = $values['sidebar_collapsed'] === 'true' ? true : false;
            $user->sidebar_collapsed = $value;
        }

        $user->save();

        return $user;
    }

    /**
     * @param \EQM\Models\Users\User $user
     * @param array $values
     * @return \EQM\Models\Users\User
     */
    public function updateSettings(User $user, array $values)
    {
        if (array_key_exists('email_notifications', $values)) {
            $user->email_notifications = true;
        } else {
            $user->email_notifications = false;
        }

        if (array_key_exists('language', $values)) {
            $user->language = $values['language'];
        }

        if (array_key_exists('timezone', $values)) {
            $user->timezone = $values['timezone'];
        }

        $user->save();

        return $user;
    }

    /**
     * @param \EQM\Models\Users\User $user
     */
    public function delete(User $user)
    {
        $user->delete();
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
        return $this->user->_search($input);
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
        return $this->user->latest()->paginate($limit);
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

    /**
     * @param string $slug
     * @return int
     */
    public function findSlugCount($slug)
    {
        return count($this->user->whereRaw("slug REGEXP '^{$slug}(-[0-9]*)?$'")->get());
    }

    /**
     * @param string $slug
     * @return \EQM\Models\Users\User
     */
    public function findBySlug($slug)
    {
        return $this->user->where('slug', $slug)->firstOrFail();
    }

    /**
     * @param \EQM\Models\Users\User $user
     * @return \EQM\Models\Users\User[]
     */
    public function getLatest(User $user)
    {
        return $this->user->where('activated', true)
            ->where('id', '!=', $user->id())
            ->orderBy('created_at', 'DESC')->limit(3)->get();
    }

    /**
     * @return \EQM\Models\Users\User[]
     */
    public function findUnactivatedUsers()
    {
        $fiveDaysAgo = Carbon::now()->subDay(5);

        return $this->user
            ->where('activated', false)
            ->where('reminder_sent', false)
            ->where('created_at', '<', $fiveDaysAgo)
            ->get();
    }

    /**
     * @param \EQM\Models\Users\User $user
     * @return \EQM\Models\Users\User
     */
    public function reminded(User $user)
    {
        $user->reminder_sent = true;
        $user->save();

        return $user;
    }

    /**
     * @return int
     */
    public function countUnactivatedUsers()
    {
        return count($this->user->where('activated', false)->get());
    }

    /**
     * @param \EQM\Models\Users\User $user
     * @return \EQM\Models\Users\User
     */
    public function resetNotificationCount(User $user)
    {
        $user->unread_notifications = 0;
        $user->save();

        return $user;
    }

    /**
     * @param \EQM\Models\Users\User $user
     * @return \EQM\Models\Users\User
     */
    public function updateUnreadNotifications(User $user)
    {
        $user->unread_notifications += 1;
        $user->save();

        return $user;
    }
}
