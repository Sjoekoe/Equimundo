<?php
namespace HorseStories\Listeners\Events;

use HorseStories\Core\Mailers\UserMailer;
use HorseStories\Events\UserRegistered;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class EmailRegisteredUser {
    /**
     * @var \HorseStories\Core\Mailers\UserMailer
     */
    private $mailer;

    /**
     * Create the event handler.
     *
     * @param \HorseStories\Core\Mailers\UserMailer $mailer
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
