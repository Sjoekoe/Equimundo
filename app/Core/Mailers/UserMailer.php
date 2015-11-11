<?php
namespace EQM\Core\Mailers;

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
}
