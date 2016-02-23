<?php
namespace EQM\Http\Controllers\Horses;

use EQM\Events\HorseWasFollowed;
use EQM\Http\Controllers\Controller;
use EQM\Models\Follows\FollowsRepository;
use EQM\Models\Horses\Horse;
use EQM\Models\Notifications\Notification;
use EQM\Models\Notifications\NotificationRepository;

class FollowsController extends Controller
{
    /**
     * @var \EQM\Models\Follows\FollowsRepository
     */
    private $follows;

    /**
     * @var \EQM\Models\Notifications\NotificationRepository
     */
    private $notifications;

    public function __construct(FollowsRepository $follows, NotificationRepository $notifications)
    {
        $this->follows = $follows;
        $this->notifications = $notifications;
    }

    public function index(Horse $horse)
    {
        $followers = $this->follows->findForHorse($horse);

        return view('follows.index', compact('horse', 'followers'));
    }

    public function store(Horse $horse)
    {
        $this->authorize('follow-horse', $horse);

        auth()->user()->follow($horse);

        event(new HorseWasFollowed(
            $horse,
            auth()->user(),
            Notification::HORSE_FOLLOWED,
            ['follower' => auth()->user()->fullName(), 'horse' => $horse->name()]
        ));

        session()->put('success', 'You are now following ' . $horse->name());

        return redirect()->back();
    }

    public function destroy(Horse $horse)
    {
        $this->authorize('unfollow-horse', $horse);

        auth()->user()->unFollow($horse);

        session()->put('succes', 'You are no longer following ' . $horse->name());

        return redirect()->back();
    }
}
