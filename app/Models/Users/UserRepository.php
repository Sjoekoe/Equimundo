<?php
namespace EQM\Models\Users;

use Carbon\Carbon;

interface UserRepository
{
    /**
     * @param array $values
     * @return \EQM\Models\Users\User
     */
    public function create(array $values);

    /**
     * @param \EQM\Models\Users\User $user
     * @return \EQM\Models\Users\User
     */
    public function activate(User $user);

    /**
     * @param \EQM\Models\Users\User $user
     * @param array $values
     * @return \EQM\Models\Users\User
     */
    public function update(User $user, array $values);

    /**
     * @param \EQM\Models\Users\User $user
     * @param array $values
     * @return \EQM\Models\Users\User
     */
    public function updateSettings(User $user, array $values);

    /**
     * @param \EQM\Models\Users\User $user
     */
    public function delete(User $user);

    /**
     * @param int $id
     * @return \EQM\Models\Users\User
     */
    public function findById($id);

    /**
     * @param string $email
     * @return \EQM\Models\Users\User
     */
    public function findByEmail($email);

    /**
     * @param int $id
     * @param string $token
     * @return \EQM\Models\Users\User
     */
    public function findByIdAndToken($id, $token);

    /**
     * @return \EQM\Models\Users\User[]
     */
    public function all();

    /**
     * @param string $input
     * @return \EQM\Models\Users\User[]
     */
    public function search($input);

    /**
     * @return int
     */
    public function count();

    /**
     * @param int $limit
     * @return \EQM\Models\Users\User[]
     */
    public function paginated($limit = 20);

    /**
     * @param \Carbon\Carbon $start
     * @param \Carbon\Carbon $end
     * @return int
     */
    public function findCountByDate(Carbon $start, Carbon $end);

    /**
     * @param \Carbon\Carbon $date
     * @return int
     */
    public function findRegisteredUsersBeforeDate(Carbon $date);

    /**
     * @param string $slug
     * @return int
     */
    public function findSlugCount($slug);

    /**
     * @param string $slug
     * @return \EQM\Models\Users\User
     */
    public function findBySlug($slug);

    /**
     * @param \EQM\Models\Users\User $user
     * @return \EQM\Models\Users\User[]
     */
    public function getLatest(User $user);

    /**
     * @return \EQM\Models\Users\User[]
     */
    public function findUnactivatedUsers();

    /**
     * @param \EQM\Models\Users\User $user
     * @return \EQM\Models\Users\User
     */
    public function reminded(User $user);

    /**
     * @return int
     */
    public function countUnactivatedUsers();

    /**
     * @param \EQM\Models\Users\User $user
     * @return \EQM\Models\Users\User
     */
    public function resetNotificationCount(User $user);

    /**
     * @param \EQM\Models\Users\User $user
     * @return \EQM\Models\Users\User
     */
    public function updateUnreadNotifications(User $user);
}
