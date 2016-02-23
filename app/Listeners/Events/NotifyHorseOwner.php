<?php
namespace EQM\Listeners\Events;

use EQM\Core\Mailers\UserMailer;
use EQM\Events\PedigreeWasCreated;
use EQM\Models\Notifications\NotificationRepository;

class NotifyHorseOwner
{
    /**
     * @var \EQM\Models\Notifications\NotificationRepository
     */
    private $notifications;

    /**
     * @var \EQM\Core\Mailers\UserMailer
     */
    private $mailer;

    /**
     * @param \EQM\Models\Notifications\NotificationRepository $notifications
     * @param \EQM\Core\Mailers\UserMailer $mailer
     */
    public function __construct(NotificationRepository $notifications, UserMailer $mailer)
    {
        $this->notifications = $notifications;
        $this->mailer = $mailer;
    }

    /**
     * @param \EQM\Events\PedigreeWasCreated $event
     */
    public function handle(PedigreeWasCreated $event)
    {
        if (count($event->family->userTeams())) {
            foreach ($event->family->userTeams as $userTeam) {
                $user = $userTeam->user()->first();
                $this->notifications->create(auth()->user(), $user, $event->notification, $event->horse, $event->data);

                if ($user->emailNotifications()) {
                    $this->mailer->sendPedigreeCreated($user, $event->family, $event->horse, auth()->user());
                }
            }
        }
    }
}
