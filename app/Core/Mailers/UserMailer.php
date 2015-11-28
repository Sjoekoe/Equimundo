<?php
namespace EQM\Core\Mailers;

use EQM\Models\Statuses\Status;
use EQM\Models\Users\User;

class UserMailer extends Mailer
{
    /**
     * @param \EQM\Models\Users\User $user
     */
    public function sendWelcomeMessageTo(User $user)
    {
        $subject = 'Welcome to Equimundo';
        $view = 'emails.registration.confirm';
        $data = [
            'activationLink' => route('activate', ['token' => $user->getRememberToken(), 'email' => $user->email()]),
        ];

        return $this->sendTo($user, $subject, $view, $data);
    }

    /**
     * @param \EQM\Models\Users\User $user
     * @param \EQM\Models\Statuses\Status $status
     * @param \EQM\Models\Users\User $sender
     */
    public function sendStatusLikedTo(User $user, Status $status, User $sender)
    {
        $subject = $sender->fullName() . ' likes the status of ' . $status->horse()->name();
        $view = 'emails.statuses.liked';
        $data = [
            'link' => route('statuses.show', $status->id()),
            'sender' => $sender,
        ];

        return $this->sendTo($user, $subject, $view, $data);
    }
}
