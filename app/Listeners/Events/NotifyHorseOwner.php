<?php
namespace EQM\Listeners\Events;

use EQM\Core\Mailers\UserMailer;
use EQM\Events\PedigreeWasCreated;
use EQM\Models\Notifications\NotificationCreator;

class NotifyHorseOwner
{
    /**
     * @var \EQM\Core\Mailers\UserMailer
     */
    private $mailer;

    /**
     * @var \EQM\Models\Notifications\NotificationCreator
     */
    private $creator;

    public function __construct(UserMailer $mailer, NotificationCreator $creator)
    {
        $this->mailer = $mailer;
        $this->creator = $creator;
    }

    /**
     * @param \EQM\Events\PedigreeWasCreated $event
     */
    public function handle(PedigreeWasCreated $event)
    {
        if (count($event->family->userTeams())) {
            foreach ($event->family->userTeams as $userTeam) {
                $user = $userTeam->user()->first();
                $this->creator->create(auth()->user(), $user, $event->notification, $event->horse, $event->data);

                if ($user->emailNotifications()) {
                    $this->mailer->sendPedigreeCreated($user, $event->family, $event->horse, auth()->user());
                }
            }
        }
    }
}
