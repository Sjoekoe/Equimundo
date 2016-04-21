<?php
namespace EQM\Providers;

use EQM\Models\Comments\CommentPolicy;
use EQM\Models\Companies\CompanyPolicy;
use EQM\Models\Conversations\ConversationPolicy;
use EQM\Models\Horses\HorsePolicy;
use EQM\Models\Notifications\NotificationPolicy;
use EQM\Models\Statuses\StatusPolicy;
use EQM\Policies\Policies;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    use Policies;

    /**
     * @param \Illuminate\Contracts\Auth\Access\Gate $gate
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        foreach ($this->commentPolicies as $policy) {
            $gate->define($policy, CommentPolicy::class . '@authorize');
        }

        foreach ($this->commentPrivilegePolicies as $policy) {
            $gate->define($policy, CommentPolicy::class . '@privilege');
        }
        
        foreach ($this->companyPolicies as $policy) {
            $gate->define($policy, CompanyPolicy::class . '@authorize');
        }

        foreach ($this->conversationPolicies as $policy) {
            $gate->define($policy, ConversationPolicy::class . '@authorize');
        }

        foreach ($this->horseTeamPolicies as $policy) {
            $gate->define($policy, HorsePolicy::class . '@horseOwner');
        }

        foreach ($this->horsePolicies as $policy) {
            $gate->define($policy, HorsePolicy::class . '@otherUsers');
        }

        foreach ($this->notificationPolicies as $policy) {
            $gate->define($policy, NotificationPolicy::class . '@authorize');
        }

        foreach ($this->statusPolicies as $policy) {
            $gate->define($policy, StatusPolicy::class . '@authorize');
        }
    }
}
