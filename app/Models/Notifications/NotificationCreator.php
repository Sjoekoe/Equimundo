<?php
namespace EQM\Models\Notifications;

use EQM\Events\NotificationWasSent;
use EQM\Models\Users\User;
use Illuminate\Contracts\Events\Dispatcher;

class NotificationCreator
{
    /**
     * @var \EQM\Models\Notifications\NotificationRepository
     */
    private $notifications;

    /**
     * @var \Illuminate\Contracts\Events\Dispatcher
     */
    private $dispatcher;

    public function __construct(NotificationRepository $notifications, Dispatcher $dispatcher)
    {
        $this->notifications = $notifications;
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param \EQM\Models\Users\User $sender
     * @param \EQM\Models\Users\User $receiver
     * @param \EQM\Models\Notifications\Notification|int $type
     * @param $entity
     * @param array $data
     * @return \EQM\Models\Notifications\Notification
     */
    public function create(User $sender, User $receiver, $type, $entity, $data)
    {
        $notification = $this->notifications->create($sender, $receiver, $type, $entity, $data);

        $this->dispatcher->fire(new NotificationWasSent($receiver, $notification));

        return $notification;
    }
}
