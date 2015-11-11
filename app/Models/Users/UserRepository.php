<?php
namespace EQM\Models\Users;

interface UserRepository
{
    /**
     * @param array $values
     * @return \EQM\Models\Users\User
     */
    public function create(array $values);

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
}
