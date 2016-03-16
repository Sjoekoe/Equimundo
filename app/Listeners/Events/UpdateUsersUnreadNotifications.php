<?php
namespace EQM\Listeners\Events;

use EQM\Events\NotificationWasSent;
use EQM\Models\Users\UserRepository;

class UpdateUsersUnreadNotifications
{
    /**
     * @var \EQM\Models\Users\UserRepository
     */
    private $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function handle(NotificationWasSent $event)
    {
        $this->users->updateUnreadNotifications($event->user);
    }
}
