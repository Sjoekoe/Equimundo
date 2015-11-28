<?php
namespace EQM\Listeners\Events;

use EQM\Models\Notifications\NotificationRepository;
use Illuminate\Auth\AuthManager;

class NotifyStatusPoster
{
    /**
     * @var \EQM\Models\Notifications\NotificationRepository
     */
    private $notifications;

    /**
     * @var \Illuminate\Auth\AuthManager
     */
    private $auth;

    public function __construct(NotificationRepository $notifications, AuthManager $auth)
    {
        $this->notifications = $notifications;
        $this->auth = $auth;
    }

    public function handle($event)
    {
        foreach ($event->status->horse()->users() as $user) {
            if ($user->id() !== $this->auth->user()->id()) {
                $this->notifications->create($event->sender, $user, $event->notification, $event->status, $event->data);
            }
        }
    }
}
