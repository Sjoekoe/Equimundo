<?php
namespace EQM\Api\Http\Controllers;

use EQM\Api\Http\Controller;
use EQM\Api\Users\UserTransformer;
use EQM\Models\Notifications\Notification;
use EQM\Models\Notifications\NotificationRepository;
use EQM\Models\Notifications\NotificationTransformer;
use EQM\Models\Users\User;
use EQM\Models\Users\UserRepository;

class NotificationController extends Controller
{
    /**
     * @var \EQM\Models\Notifications\NotificationRepository
     */
    private $notifications;

    /**
     * @var \EQM\Models\Users\UserRepository
     */
    private $users;

    public function __construct(NotificationRepository $notifications, UserRepository $users)
    {
        $this->notifications = $notifications;
        $this->users = $users;
    }

    public function index()
    {
        $notifications = $this->notifications->findForUser(auth()->user());

        return $this->response()->paginator($notifications, new NotificationTransformer());
    }

    public function show(Notification $notification)
    {
        return $this->response()->item($notification, new NotificationTransformer());
    }

    public function markRead()
    {
        auth()->user()->markNotificationsAsRead();

        $notifications = $this->notifications->findForUser(auth()->user());

        return $this->response()->paginator($notifications, new NotificationTransformer());
    }

    public function resetCount(User $user)
    {
        $user = $this->users->resetNotificationCount($user);

        return $this->response()->item($user, new UserTransformer());
    }

    public function delete(Notification $notification)
    {
        $this->notifications->delete($notification);

        return $this->response()->noContent();
    }
}
