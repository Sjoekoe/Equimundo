<?php
namespace HorseStories\Models\Notifications;

use HorseStories\Models\Users\User;

class NotificationRepository
{
    /**
     * @var \HorseStories\Models\Notifications\Notification
     */
    private $notification;

    /**
     * @param \HorseStories\Models\Notifications\Notification $notification
     */
    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }

    /**
     * @param \HorseStories\Models\Users\User $user
     * @return \HorseStories\Models\Notifications\Notification[]
     */
    public function findForUser(User $user)
    {
        return $this->notification->where('receiver_id', $user->id)->get();
    }
}
