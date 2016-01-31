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
}
