<?php
namespace EQM\Providers;

use EQM\Models\Advertising\Contacts\AdvertisingContactRouteBinding;
use EQM\Models\Albums\AlbumRouteBinder;
use EQM\Models\Comments\CommentRouteBinder;
use EQM\Models\Conversations\ConversationRouteBinder;
use EQM\Models\Horses\HorseRouteBinder;
use EQM\Models\Horses\HorseSlugRouteBinder;
use EQM\Models\HorseTeams\HorseTeamRouteBinder;
use EQM\Models\Notifications\NotificationRouteBinder;
use EQM\Models\Palmares\PalmaresRouteBinder;
use EQM\Models\Pedigrees\PedigreeRouteBinder;
use EQM\Models\Pictures\PictureRouteBinder;
use EQM\Models\Statuses\StatusRouteBinder;
use EQM\Models\Users\UserRouteBinder;
use EQM\Models\Users\UserSlugRouteBinder;
use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider {

    /**
     * @var string
     */
    protected $namespace = 'EQM\Http\Controllers';

    public function boot(Router $router)
    {
        parent::boot($router);

        $router->bind('advertising_contact', AdvertisingContactRouteBinding::class);
        $router->bind('album', AlbumRouteBinder::class);
        $router->bind('comment', CommentRouteBinder::class);
        $router->bind('conversation', ConversationRouteBinder::class);
        $router->bind('horse', HorseRouteBinder::class);
        $router->bind('horse_team', HorseTeamRouteBinder::class);
        $router->bind('horse_slug', HorseSlugRouteBinder::class);
        $router->bind('notification', NotificationRouteBinder::class);
        $router->bind('palmares', PalmaresRouteBinder::class);
        $router->bind('pedigree', PedigreeRouteBinder::class);
        $router->bind('picture', PictureRouteBinder::class);
        $router->bind('status', StatusRouteBinder::class);
        $router->bind('user', UserRouteBinder::class);
        $router->bind('user_slug', UserSlugRouteBinder::class);
    }

    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace], function($router)
        {
            require app_path('Http/routes.php');
        });
    }

}
