<?php
namespace HorseStories\Core\Mailers;

use HorseStories\Models\Users\User;

class UserMailer extends Mailer
{
    /**
     * @param \HorseStories\Models\Users\User $user
     */
    public function sendWelcomeMessageTo(User $user)
    {
        $subject = 'Welcome to Horse Stories';
        $view = 'emails.registration.confirm';
        $data = [
            'activationLink' => route('activate', ['token' => $user->getRememberToken(), 'email' => $user->email]),
        ];

        return $this->sendTo($user, $subject, $view, $data);
    }
}
