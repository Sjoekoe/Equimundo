<?php
namespace EQM\Listeners\Events;

use EQM\Events\HorseWasFollowed;
use EQM\Models\Notifications\NotificationCreator;

class SendHorseFollowedNotification
{
    /**
     * @var \EQM\Models\Notifications\NotificationCreator
     */
    private $creator;

    public function __construct(NotificationCreator $creator)
    {
        $this->creator = $creator;
    }

    public function handle(HorseWasFollowed $event)
    {
        if (count($event->horse->userTeams())) {
            foreach ($event->horse->userTeams as $userTeam) {
                $user = $userTeam->user()->first();
                $this->creator->create($event->user, $user, $event->notification, $event->user, $event->data);
            }
        }
    }
}
