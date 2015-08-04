<?php
namespace EQM\Models\Notifications;

use EQM\Models\Users\User;

class NotificationRepository
{
    /**
     * @var \EQM\Models\Notifications\Notification
     */
    private $notification;

    /**
     * @param \EQM\Models\Notifications\Notification $notification
     */
    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }

    /**
     * @param \EQM\Models\Users\User $user
     * @return \EQM\Models\Notifications\Notification[]
     */
    public function findForUser(User $user)
    {
        return $this->notification->where('receiver_id', $user->id)->get();
    }
}
