<?php
namespace EQM\Http\Controllers\Api;

use EQM\Http\Controllers\Controller;
use EQM\Models\Notifications\Notification;
use EQM\Models\Notifications\NotificationRepository;
use EQM\Models\Notifications\NotificationTransformer;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Serializer\DataArraySerializer;

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
        $manager = new Manager();
        $manager->setSerializer(new DataArraySerializer());

        $notifications = $this->notifications->findForUser(auth()->user());

        $collection  = new Collection($notifications, new NotificationTransformer());
        $result = $manager->createData($collection)->toArray();

        return response($result);
    }

    public function markRead()
    {
        auth()->user()->markNotificationsAsRead();

        $manager = new Manager();
        $manager->setSerializer(new DataArraySerializer());

        $notifications = $this->notifications->findForUser(auth()->user());

        $collection  = new Collection($notifications, new NotificationTransformer());
        $result = $manager->createData($collection)->toArray();

        return response($result);
    }

    public function delete(Notification $notification)
    {
        $this->notifications->delete($notification);

        return response('', 204);
    }
}
