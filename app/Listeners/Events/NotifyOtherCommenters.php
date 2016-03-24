<?php
namespace EQM\Listeners\Events;

use EQM\Events\CommentWasPosted;
use EQM\Models\Comments\Comment;
use EQM\Models\Notifications\NotificationCreator;
use EQM\Models\Users\User;

class NotifyOtherCommenters
{
    /**
     * @var \EQM\Models\Notifications\NotificationCreator
     */
    private $creator;

    private $notifiedIds = [];

    public function __construct(NotificationCreator $creator)
    {
        $this->creator = $creator;
    }

    public function handle(CommentWasPosted $event)
    {
        foreach ($event->status->comments() as $comment) {
            $poster = $comment->poster();

            if ($this->isNotTheAuthenticatedUser($poster) && $this->isNotInTheHorsesTeam($poster, $comment) && $this->hasNotBeenNotifiedYet($poster)) {
                $this->creator->create($event->sender, $poster, $event->notification, $event->status, $event->data);

                array_push($this->notifiedIds, $poster->id());
            }
        }
    }

    /**
     * @param \EQM\Models\Users\User $poster
     * @return bool
     */
    private function isNotTheAuthenticatedUser(User $poster)
    {
        return $poster->id() !== auth()->user()->id();
    }

    /**
     * @param \EQM\Models\Users\User $poster
     * @param \EQM\Models\Comments\Comment $comment
     * @return bool
     */
    private function isNotInTheHorsesTeam(User $poster, Comment $comment)
    {
        return ! in_array($poster, $comment->status()->horse()->users());
    }

    private function hasNotBeenNotifiedYet(User $poster)
    {
        return ! in_array($poster->id(), $this->notifiedIds);
    }
}
