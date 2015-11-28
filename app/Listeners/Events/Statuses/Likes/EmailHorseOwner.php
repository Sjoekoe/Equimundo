<?php
namespace EQM\Listeners\Events\Statuses\Likes;

use EQM\Core\Mailers\UserMailer;
use EQM\Events\StatusLiked;
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
        foreach ($event->status->horse()->users() as $user) {
            if ($user->id() !== $this->auth->user()->id()) {
                $this->mailer->sendStatusLikedTo($user, $event->status, $event->sender);
            }
        }
    }
}
