<?php namespace EQM\Providers;

use Carbon\Carbon;
use EQM\Events\CommentWasLiked;
use EQM\Events\CommentWasPosted;
use EQM\Events\HorseWasFollowed;
use EQM\Events\PedigreeWasCreated;
use EQM\Events\SearchWasPerformed;
use EQM\Events\StatusLiked;
use EQM\Events\UserRegistered;
use EQM\Listeners\Events\EmailRegisteredUser;
use EQM\Listeners\Events\NotifyCommentPoster;
use EQM\Listeners\Events\NotifyHorseOwner;
use EQM\Listeners\Events\NotifyStatusPoster;
use EQM\Listeners\Events\SendHorseFollowedNotification;
use EQM\Listeners\Events\Statuses\Likes\EmailHorseOwner;
use EQM\Listeners\Events\UpdateSearchTable;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Request;

class EventServiceProvider extends ServiceProvider {

    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        CommentWasLiked::class => [
            NotifyCommentPoster::class,
        ],
        CommentWasPosted::class => [
            NotifyStatusPoster::class,
        ],
        HorseWasFollowed::class => [
            SendHorseFollowedNotification::class,
        ],
        PedigreeWasCreated::class => [
            NotifyHorseOwner::class,
        ],
        SearchWasPerformed::class => [
            UpdateSearchTable::class,
        ],
        StatusLiked::class => [
            NotifyStatusPoster::class,
            EmailHorseOwner::class,
        ],
        UserRegistered::class => [
            EmailRegisteredUser::class,
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        $events->listen('auth.login', function ($user, $remember) {
            $user->last_login = Carbon::now();
            $user->ip = Request::ip();
            $user->save();
        });
    }
}
