<?php
namespace EQM\Listeners\Events;

use EQM\Models\Notifications\NotificationCreator;

class NotifyStatusPoster
{
    /**
     * @var \EQM\Models\Notifications\NotificationCreator
     */
    private $creator;

    public function __construct(NotificationCreator $creator)
    {
        $this->creator = $creator;
    }

    public function handle($event)
    {
        foreach ($event->status->horse()->users() as $user) {
            if ($user->id() !== auth()->user()->id()) {
                $this->creator->create($event->sender, $user, $event->notification, $event->status, $event->data);
            }
        }
    }
}
