<?php
namespace EQM\Models\Statuses;

use EQM\Models\Horses\Horse;
use EQM\Models\Users\User;

interface StatusRepository
{
    /**
     * @param $id
     * @return \EQM\Models\Statuses\Status
     */
    public function findById($id);

    /**
     * @param \EQM\Models\Users\User $user
     * @return \EQM\Models\Statuses\Status
     */
    public function findAllForUser(User $user);

    /**
     * @param \EQM\Models\Users\User $user
     * @return \EQM\Models\Statuses\Status
     */
    public function findFeedForUser(User $user);

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @return \EQM\Models\Horses\Horse
     */
    public function findFeedForHorse(Horse $horse);

    /**
     * @param array $data
     * @return \EQM\Models\Statuses\Status
     */
    public function create(array $data = []);

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @param array $data
     * @return \EQM\Models\Statuses\Status
     */
    public function createForPalmares(Horse $horse, array $data = []);

    /**
     * @param \EQM\Models\Statuses\Status $status
     * @param array $values
     * @return \EQM\Models\Statuses\Status
     */
    public function update(Status $status, array $values = []);
}
