<?php
namespace EQM\Listeners\Events;

use EQM\Core\Mailers\UserMailer;
use EQM\Events\UserRegistered;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class EmailRegisteredUser {
    /**
     * @var \EQM\Core\Mailers\UserMailer
     */
    private $mailer;

    /**
     * Create the event handler.
     *
     * @param \EQM\Core\Mailers\UserMailer $mailer
     */
    public function __construct(UserMailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
	 * Handle the event.
	 *
	 * @param  UserRegistered  $event
	 * @return void
	 */
    public function handle(UserRegistered $event)
    {
        $this->mailer->sendWelcomeMessageTo($event->user);
    }
}
