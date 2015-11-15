<?php
namespace EQM\Http\Controllers\Notifications;

use EQM\Http\Controllers\Controller;
use EQM\Models\Notifications\Notification;
use EQM\Models\Notifications\NotificationRepository;

class NotificationController extends Controller
{
    /**
     * @var \EQM\Models\Notifications\NotificationRepository
     */
    private $notifications;

    public function __construct(NotificationRepository $notifications)
    {
        $this->notifications = $notifications;
    }

    public function index()
    {
        $notifications = $this->notifications->findForUser(auth()->user());

        return view('notifications.index', compact('notifications'));
    }

    public function markRead(Notification $notification = null)
    {
        $this->authorize('mark-as-read', $notification);

        auth()->user()->markNotificationsAsRead();

        return redirect()->back();
    }
}
