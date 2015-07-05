<?php namespace HorseStories\Providers;

use HorseStories\Events\StatusLiked;
use HorseStories\Events\UserRegistered;
use HorseStories\Listeners\Events\EmailRegisteredUser;
use HorseStories\Listeners\Events\NotifyStatusPoster;
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
