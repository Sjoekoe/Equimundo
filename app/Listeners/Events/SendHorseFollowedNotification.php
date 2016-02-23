<?php
namespace EQM\Listeners\Events;

use EQM\Events\HorseWasFollowed;
use EQM\Models\Notifications\NotificationRepository;

class SendHorseFollowedNotification
{
    /**
     * @var \EQM\Models\Notifications\NotificationRepository
     */
    private $notifications;

    public function __construct(NotificationRepository $notifications)
    {
        $this->notifications = $notifications;
    }

    public function handle(HorseWasFollowed $event)
    {
        if (count($event->horse->userTeams())) {
            foreach ($event->horse->userTeams as $userTeam) {
                $user = $userTeam->user()->first();
                $this->notifications->create($event->user, $user, $event->notification, $event->user, $event->data);
            }
        }
    }
}
