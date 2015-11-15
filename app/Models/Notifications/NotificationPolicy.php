<?php
namespace EQM\Models\Notifications;

use EQM\Models\Users\User;

class NotificationPolicy
{
    /**
     * @param \EQM\Models\Users\User $user
     * @param \EQM\Models\Notifications\Notification $notification
     * @return bool
     */
    public function authorize(User $user, Notification $notification)
    {
        return $notification->receiver()->id() == $user->id();
    }
}
