<?php
namespace EQM\Http\Controllers\Notifications;

use EQM\Models\Notifications\Notification;
use EQM\Models\Notifications\NotificationRepository;
use Illuminate\Routing\Controller;

class NotificationController extends Controller
{
    /**
     * @var \EQM\Models\Notifications\NotificationRepository
     */
    private $notifications;

    /**
     * @param \EQM\Models\Notifications\NotificationRepository $notifications
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
        $notifications = $this->notifications->findForUser(auth()->user());

        return view('notifications.index', compact('notifications'));
    }

    /**
     * @param \EQM\Models\Notifications\Notification $notification
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markRead(Notification $notification = null)
    {
        auth()->user()->markNotificationsAsRead();

        return redirect()->back();
    }
}
