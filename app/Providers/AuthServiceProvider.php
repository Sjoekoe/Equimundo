<?php
namespace EQM\Providers;

use EQM\Models\Comments\Comment;
use EQM\Models\Comments\CommentPolicy;
use EQM\Models\Conversations\Conversation;
use EQM\Models\Conversations\ConversationPolicy;
use EQM\Models\Horses\Horse;
use EQM\Models\Horses\HorsePolicy;
use EQM\Models\Notifications\Notification;
use EQM\Models\Notifications\NotificationPolicy;
use EQM\Models\Statuses\Status;
use EQM\Models\Statuses\StatusPolicy;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * @param \Illuminate\Contracts\Auth\Access\Gate $gate
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        foreach (Comment::POLICIES as $policy) {
            $gate->define($policy, CommentPolicy::class . '@authorize');
        }

        foreach (Conversation::POLICIES as $policy) {
            $gate->define($policy, ConversationPolicy::class . '@authorize');
        }

        foreach (Horse::TEAM_POLICIES as $policy) {
            $gate->define($policy, HorsePolicy::class . '@horseOwner');
        }

        foreach (Horse::POLICIES as $policy) {
            $gate->define($policy, HorsePolicy::class . '@otherUsers');
        }

        foreach (Notification::POLICIES as $policy) {
            $gate->define($policy, NotificationPolicy::class . '@authorize');
        }

        foreach (Status::POLICIES as $policy) {
            $gate->define($policy, StatusPolicy::class . '@authorize');
        }
    }
}
