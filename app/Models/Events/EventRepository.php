<?php
namespace EQM\Models\Events;

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
     */
    public function delete(Event $event);
}
