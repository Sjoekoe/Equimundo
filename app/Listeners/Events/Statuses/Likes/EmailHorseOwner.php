<?php
namespace EQM\Listeners\Events\Statuses\Likes;

use EQM\Core\Mailers\UserMailer;
use EQM\Events\StatusLiked;
use EQM\Models\Statuses\CompanyStatus;
use EQM\Models\Statuses\HorseStatus;
use Illuminate\Auth\AuthManager;

class EmailHorseOwner
{
    /**
     * @var \Illuminate\Auth\AuthManager
     */
    private $auth;

    /**
     * @var \EQM\Core\Mailers\UserMailer
     */
    private $mailer;

    public function __construct(AuthManager $auth, UserMailer $mailer)
    {
        $this->auth = $auth;
        $this->mailer = $mailer;
    }

    public function handle(StatusLiked $event)
    {
        if ($event->status instanceof HorseStatus) {
            foreach ($event->status->horse()->users() as $user) {
                if ($user->id() !== $this->auth->user()->id() && $user->emailNotifications()) {
                    $this->mailer->sendStatusLikedTo($user, $event->status, $event->sender);
                }
            }
        }

        if ($event->status instanceof CompanyStatus) {
            foreach ($event->status->company()->userTeams() as $teamMember) {
                $user = $teamMember->user();

                if ($user->isCompanyAdmin($event->status->company())
                    && ($user->id() !== $this->auth->user()->id())
                    && $user->emailNotifications()
                ) {
                    $this->mailer->sendStatusLikedTo($user, $event->status, $event->sender);
                }
            }
        }
    }
}
