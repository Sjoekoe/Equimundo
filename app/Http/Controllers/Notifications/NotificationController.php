<?php
namespace HorseStories\Http\Controllers\Notifications;

use Auth;
use HorseStories\Models\Notifications\NotificationRepository;
use Illuminate\Routing\Controller;

class NotificationController extends Controller
{
    /**
     * @var \HorseStories\Models\Notifications\NotificationRepository
     */
    private $notifications;

    /**
     * @param \HorseStories\Models\Notifications\NotificationRepository $notifications
     */
    public function __construct(NotificationRepository $notifications)
    {
        $this->notifications = $notifications;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $notifications = $this->notifications->findForUser(Auth::user());

        return view('notifications.index', compact('notifications'));
    }

    /**
     * @param int|null $notification
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markRead($notification = null)
    {
        Auth::user()->markNotificationsAsRead();

        return redirect()->back();
    }
}
