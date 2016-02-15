<?php
namespace EQM\Core\Mailers;

use EQM\Models\Horses\Horse;
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

    /**
     * @param \EQM\Models\Users\User $user
     * @param \EQM\Models\Horses\Horse $horse
     * @param \EQM\Models\Horses\Horse $family
     * @param \EQM\Models\Users\User $sender
     */
    public function sendPedigreeCreated(User $user, Horse $horse, Horse $family, User $sender)
    {
        $subject = 'A pedigree connection was made for ' . $horse->name();
        $view = 'emails.horses.pedigree';
        $data = [
            'link' => route('horses.show', $family->slug()),
            'sender' => $sender,
            'family' => $family,
            'horse' => $horse,
        ];

        return $this->sendTo($user, $subject, $view, $data);
    }
}
