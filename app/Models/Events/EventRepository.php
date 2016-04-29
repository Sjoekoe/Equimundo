<?php
namespace EQM\Models\Events;

use EQM\Models\Addresses\Address;
use EQM\Models\Users\User;

interface EventRepository
{
    /**
     * @param int $id
     * @return \EQM\Models\Events\Event
     */
    public function findById($id);

    /**
     * @param \EQM\Models\Users\User $user
     * @param array $values
     * @return \EQM\Models\Events\Event
     */
    public function create(User $user, $values);

    /**
     * @param \EQM\Models\Events\Event $event
     * @param \EQM\Models\Addresses\Address $address
     * @param array $values
     * @return \EQM\Models\Events\Event
     */
    public function update(Event $event, Address $address, array $values);

    /**
     * @param \EQM\Models\Events\Event $event
     */
    public function delete(Event $event);

    /**
     * @param int $limit
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function findAllPaginated($limit = 10);

    /**
     * @param \EQM\Models\Users\User $user
     * @param \EQM\Models\Addresses\Address $address
     * @param array $values
     * @return \EQM\Models\Events\Event
     */
    public function createFullSizedEvent(User $user, Address $address, array $values);
}
