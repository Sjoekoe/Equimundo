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

    public function show(Notification $notification)
    {
        $this->authorize('mark-as-read', $notification);

        $notification->markAsRead();

        return redirect()->to($notification->link());
    }

    public function delete(Notification $notification)
    {
        $this->authorize('delete-notification', $notification);

        $this->notifications->delete($notification);

        return back();
    }

    public function markRead()
    {
        auth()->user()->markNotificationsAsRead();

        return redirect()->back();
    }
}
