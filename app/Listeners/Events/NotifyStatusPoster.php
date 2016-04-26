<?php
namespace EQM\Listeners\Events;

use EQM\Models\Notifications\NotificationCreator;
use EQM\Models\Statuses\CompanyStatus;
use EQM\Models\Statuses\HorseStatus;

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
        if ($event->status instanceof HorseStatus) {
            foreach ($event->status->horse()->users() as $user) {
                if ($user->id() !== auth()->user()->id()) {
                    $this->creator->create($event->sender, $user, $event->notification, $event->status, $event->data);
                }
            }
        }

        if ($event->status instanceof CompanyStatus) {
            foreach($event->status->company()->userTeams() as $teamMember) {
                $user = $teamMember->user();
                if ($user->isCompanyAdmin($event->status->company()) && $user->id() !== auth()->user()->id()) {
                    $this->creator->create($event->sender, $user, $event->notification, $event->status, $event->data);
                }
            }
        }
    }
}
