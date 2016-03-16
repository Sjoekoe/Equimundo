<?php
namespace EQM\Http\Controllers\Api;

use EQM\Api\Users\UserTransformer;
use EQM\Http\Controllers\Controller;
use EQM\Models\Notifications\Notification;
use EQM\Models\Notifications\NotificationRepository;
use EQM\Models\Notifications\NotificationTransformer;
use EQM\Models\Users\User;
use EQM\Models\Users\UserRepository;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\DataArraySerializer;

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
        $manager = new Manager();
        $manager->setSerializer(new DataArraySerializer());

        $notifications = $this->notifications->findForUser(auth()->user());
        $collection  = new Collection($notifications, new NotificationTransformer());
        $collection->setPaginator(new IlluminatePaginatorAdapter($notifications));
        $result = $manager->createData($collection)->toArray();

        return response($result);
    }

    public function show(Notification $notification)
    {
        $manager = new Manager();
        $manager->setSerializer(new DataArraySerializer());
        $collection  = new Item($notification, new NotificationTransformer());
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

    public function resetCount(User $user)
    {
        $user = $this->users->resetNotificationCount($user);

        $manager = new Manager();
        $manager->setSerializer(new DataArraySerializer());
        $collection  = new Item($user, new UserTransformer());
        $result = $manager->createData($collection)->toArray();

        return response($result);
    }

    public function delete(Notification $notification)
    {
        $this->notifications->delete($notification);

        return response('', 204);
    }
}
