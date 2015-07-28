<?php namespace EQM\Providers;

use EQM\Events\CommentWasPosted;
use EQM\Events\HorseWasCreated;
use EQM\Events\StatusLiked;
use EQM\Events\UserRegistered;
use EQM\Listeners\Events\CreateStandardAlbums;
use EQM\Listeners\Events\EmailRegisteredUser;
use EQM\Listeners\Events\NotifyHorseOwner;
use EQM\Listeners\Events\NotifyStatusPoster;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider {

	/**
	 * The event handler mappings for the application.
	 *
	 * @var array
	 */
	protected $listen = [
		UserRegistered::class => [
			EmailRegisteredUser::class,
		],
        StatusLiked::class => [
            NotifyStatusPoster::class,
        ],
        CommentWasPosted::class => [
            NotifyStatusPoster::class
        ],
        PedigreeWasCreated::class => [
            NotifyHorseOwner::class
        ],
		HorseWasCreated::class => [
            CreateStandardAlbums::class
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
