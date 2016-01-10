<?php namespace EQM\Providers;

use EQM\Events\CommentWasLiked;
use EQM\Events\CommentWasPosted;
use EQM\Events\PalmaresWasCreated;
use EQM\Events\PalmaresWasDeleted;
use EQM\Events\PedigreeWasCreated;
use EQM\Events\StatusLiked;
use EQM\Events\UserRegistered;
use EQM\Listeners\Events\CreatePalmares;
use EQM\Listeners\Events\CreateStandardAlbums;
use EQM\Listeners\Events\DeletePalmares;
use EQM\Listeners\Events\EmailRegisteredUser;
use EQM\Listeners\Events\NotifyCommentPoster;
use EQM\Listeners\Events\NotifyHorseOwner;
use EQM\Listeners\Events\NotifyStatusPoster;
use EQM\Listeners\Events\Statuses\Likes\EmailHorseOwner;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

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
        PedigreeWasCreated::class => [
            NotifyHorseOwner::class,
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
        //

    }
}
